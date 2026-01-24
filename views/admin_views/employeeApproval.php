<?php
session_start();
if (!isset($_SESSION['userId']) || $_SESSION['role'] != 1) {
    header("Location:  ../login.php");
    exit();
}

require_once("../../models/userModel.php");
$pendingEmployees = getPendingEmployees();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Approval - GadgetGrid Admin</title>
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
            <li><a href="employeeApproval.php" class="active">👥 Employee Approval</a></li>
            <li><a href="viewAllUsers.php">📋 All Users</a></li>
            <li><a href="manageCategories.php">📁 Categories</a></li>
            <li><a href="stockLogs.php">📦 Stock Logs</a></li>
            <li><a href="profile.php">⚙️ Profile</a></li>
            <li><a href="changePassword.php">🔐 Change Password</a></li>
        </ul>
    </div>
    
    <div class="main-content">
        <div class="header">
            <h1>Employee Approval</h1>
            <div class="header-user">
                <span>Welcome, <?php echo htmlspecialchars($_SESSION['userName']); ?></span>
                <a href="../logout.php" class="btn-logout">Logout</a>
            </div>
        </div>
        
        <div class="content-box">
            <?php if (isset($_GET["success"])): ?>
                <div class="success-message"><?php echo htmlspecialchars($_GET["success"]); ?></div>
            <?php endif; ?>
            
            <?php if (isset($_GET["genErr"])): ?>
                <div class="general-error"><?php echo htmlspecialchars($_GET["genErr"]); ?></div>
            <?php endif; ?>
            
            <h2>Pending Employee Applications</h2>
            
            <?php if (empty($pendingEmployees)): ?>
                <p style="color: #666; padding: 20px 0;">No pending employee applications.</p>
            <?php else: ?>
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Applied On</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($pendingEmployees as $emp): ?>
                                <tr>
                                    <td><?php echo $emp['userId']; ?></td>
                                    <td><?php echo htmlspecialchars($emp['firstName'] . ' ' . $emp['lastName']); ?></td>
                                    <td><?php echo htmlspecialchars($emp['email']); ?></td>
                                    <td><?php echo htmlspecialchars($emp['phone'] ?? 'N/A'); ?></td>
                                    <td><?php echo date('M d, Y', strtotime($emp['created_at'])); ?></td>
                                    <td>
                                        <div class="action-btns">
                                            <form action="../../controllers/employeeApprovalControl.php" method="POST" style="display: inline;">
                                                <input type="hidden" name="employeeId" value="<?php echo $emp['userId']; ?>">
                                                <input type="hidden" name="action" value="approve">
                                                <button type="submit" class="btn btn-success btn-sm">Approve</button>
                                            </form>
                                            <form action="../../controllers/employeeApprovalControl.php" method="POST" style="display: inline;">
                                                <input type="hidden" name="employeeId" value="<?php echo $emp['userId']; ?>">
                                                <input type="hidden" name="action" value="reject">
                                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to reject this employee?');">Reject</button>
                                            </form>
                                        </div>
                                    </td>
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