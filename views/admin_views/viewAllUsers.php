<?php
session_start();
if (!isset($_SESSION['userId']) || $_SESSION['role'] != 1) {
    header("Location: ../login.php");
    exit();
}

require_once("../../models/userModel.php");
$employees = getAllEmployees();
$customers = getAllCustomers();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Users - GadgetGrid Admin</title>
    <link rel="stylesheet" href="css/admin_styles.css">
</head>
<body>
    <div class="sidebar">
        <div class="sidebar-header">
            <h2>🔌 GadgetGrid</h2>
            <p>Admin Panel</p>
        </div>
        <ul class="sidebar-menu">
            <li><a href="home.php">📊 Dashboard</a></li>
            <li><a href="employeeApproval.php">👥 Employee Approval</a></li>
            <li><a href="viewAllUsers.php" class="active">📋 All Users</a></li>
            <li><a href="manageCategories.php">📁 Categories</a></li>
            <li><a href="stockLogs.php">📦 Stock Logs</a></li>
            <li><a href="profile.php">⚙️ Profile</a></li>
            <li><a href="changePassword.php">🔐 Change Password</a></li>
        </ul>
    </div>
    
    <div class="main-content">
        <div class="header">
            <h1>All Users</h1>
            <div class="header-user">
                <span>Welcome, <?php echo htmlspecialchars($_SESSION['userName']); ?></span>
                <a href="../logout.php" class="btn-logout">Logout</a>
            </div>
        </div>
        
        <div class="content-box">
            <h2>Active Employees (<?php echo count($employees); ?>)</h2>
            <?php if (empty($employees)): ?>
                <p style="color: #666; padding: 20px 0;">No active employees. </p>
            <?php else:  ?>
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Joined On</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($employees as $emp): ?>
                                <tr>
                                    <td><?php echo $emp['userId']; ?></td>
                                    <td><?php echo htmlspecialchars($emp['firstName'] . ' ' . $emp['lastName']); ?></td>
                                    <td><?php echo htmlspecialchars($emp['email']); ?></td>
                                    <td><?php echo htmlspecialchars($emp['phone'] ?? 'N/A'); ?></td>
                                    <td><?php echo date('M d, Y', strtotime($emp['created_at'])); ?></td>
                                    <td><span class="badge badge-active">Active</span></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
        
        <div class="content-box">
            <h2>Registered Customers (<?php echo count($customers); ?>)</h2>
            <?php if (empty($customers)): ?>
                <p style="color: #666; padding:  20px 0;">No registered customers.</p>
            <?php else: ?>
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Address</th>
                                <th>Joined On</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($customers as $cust): ?>
                                <tr>
                                    <td><?php echo $cust['userId']; ?></td>
                                    <td><?php echo htmlspecialchars($cust['firstName'] . ' ' . $cust['lastName']); ?></td>
                                    <td><?php echo htmlspecialchars($cust['email']); ?></td>
                                    <td><?php echo htmlspecialchars($cust['phone'] ??  'N/A'); ?></td>
                                    <td><?php echo htmlspecialchars($cust['address'] ?? 'N/A'); ?></td>
                                    <td><?php echo date('M d, Y', strtotime($cust['created_at'])); ?></td>
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