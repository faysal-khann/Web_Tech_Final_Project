<?php
session_start();
if (!isset($_SESSION['userId']) || $_SESSION['role'] != 1) {
    header("Location: ../login.php");
    exit();
}

require_once("../../models/stockModel.php");
$stockLogs = getAllStockLogs();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stock Logs - GadgetGrid Admin</title>
    <link rel="stylesheet" href="css/admin_styles.css">
</head>
<body>
    <div class="sidebar">
        <div class="sidebar-header">
            <h2>🔌 GadgetGrid</h2>
            <p>Admin Panel</p>
        </div>
        <ul class="sidebar-menu">
            <li><a href="home.php">Dashboard</a></li>
            <li><a href="employeeApproval.php">Employee Approval</a></li>
            <li><a href="viewAllUsers.php">All Users</a></li>
            <li><a href="manageCategories.php">Categories</a></li>
            <li><a href="stockLogs.php" class="active"> Stock Logs</a></li>
            <li><a href="profile.php"> Profile</a></li>
            <li><a href="changePassword.php"> Change Password</a></li>
        </ul>
    </div>
    
    <div class="main-content">
        <div class="header">
            <h1>Stock Activity Logs</h1>
            <div class="header-user">
                <span>Welcome, <?php echo htmlspecialchars($_SESSION['userName']); ?></span>
                <a href="../logout.php" class="btn-logout">Logout</a>
            </div>
        </div>
        
        <div class="content-box">
            <h2>All Stock In/Out Activities</h2>
            
            <?php if (empty($stockLogs)): ?>
                <p style="color: #666; padding:  20px 0;">No stock activities recorded yet.</p>
            <?php else: ?>
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>Log ID</th>
                                <th>Product</th>
                                <th>Activity</th>
                                <th>Quantity</th>
                                <th>Employee</th>
                                <th>Notes</th>
                                <th>Date & Time</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($stockLogs as $log): ?>
                                <tr>
                                    <td><?php echo $log['logId']; ?></td>
                                    <td><?php echo htmlspecialchars($log['productName']); ?></td>
                                    <td>
                                        <?php if ($log['activity'] == 'stock_in'): ?>
                                            <span class="stock-in">📥 Stock In</span>
                                        <?php else: ?>
                                            <span class="stock-out">📤 Stock Out</span>
                                        <?php endif; ?>
                                    </td>
                                    <td><?php echo $log['quantity']; ?></td>
                                    <td><?php echo htmlspecialchars($log['firstName'] . ' ' . $log['lastName']); ?></td>
                                    <td><?php echo htmlspecialchars($log['notes'] ?? 'N/A'); ?></td>
                                    <td><?php echo date('M d, Y H:i', strtotime($log['created_at'])); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>