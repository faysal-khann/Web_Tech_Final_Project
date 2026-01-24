<?php
session_start();
if (!isset($_SESSION['userId']) || $_SESSION['role'] != 1) {
    header("Location: ../login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Password - GadgetGrid Admin</title>
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
            <li><a href="viewAllUsers.php">📋 All Users</a></li>
            <li><a href="manageCategories.php">📁 Categories</a></li>
            <li><a href="stockLogs.php">📦 Stock Logs</a></li>
            <li><a href="profile.php">⚙️ Profile</a></li>
            <li><a href="changePassword.php" class="active">🔐 Change Password</a></li>
        </ul>
    </div>
    
    <div class="main-content">
        <div class="header">
            <h1>Change Password</h1>
            <div class="header-user">
                <span>Welcome, <?php echo htmlspecialchars($_SESSION['userName']); ?></span>
                <a href="../logout.php" class="btn-logout">Logout</a>
            </div>
        </div>
        
        <div class="content-box" style="max-width: 500px;">
            <?php if (isset($_GET["success"])): ?>
                <div class="success-message"><?php echo htmlspecialchars($_GET["success"]); ?></div>
            <?php endif; ?>
            
            <?php if (isset($_GET["genErr"])): ?>
                <div class="general-error"><?php echo htmlspecialchars($_GET["genErr"]); ?></div>
            <?php endif; ?>
            
            <form action="../../controllers/passwordControl.php" method="POST" id="passwordForm">
                <div class="form-group">
                    <label for="currentPassword">Current Password *</label>
                    <input type="password" id="currentPassword" name="currentPassword">
                    <?php if (isset($_GET["currentPassErr"])): ?>
                        <span class="error-message"><?php echo htmlspecialchars($_GET["currentPassErr"]); ?></span>
                    <?php endif; ?>
                    <span class="error-message" id="currentPassError"></span>
                </div>
                
                <div class="form-group">
                    <label for="newPassword">New Password *</label>
                    <input type="password" id="newPassword" name="newPassword">
                    <?php if (isset($_GET["newPassErr"])): ?>
                        <span class="error-message"><?php echo htmlspecialchars($_GET["newPassErr"]); ?></span>
                    <?php endif; ?>
                    <span class="error-message" id="newPassError"></span>
                </div>
                
                <div class="form-group">
                    <label for="confirmPassword">Confirm New Password *</label>
                    <input type="password" id="confirmPassword" name="confirmPassword">
                    <?php if (isset($_GET["confirmPassErr"])): ?>
                        <span class="error-message"><?php echo htmlspecialchars($_GET["confirmPassErr"]); ?></span>
                    <?php endif; ?>
                    <span class="error-message" id="confirmPassError"></span>
                </div>
                
                <button type="submit" class="btn btn-primary">Change Password</button>
            </form>
        </div>
    </div>
    
    <script>
        document.getElementById('passwordForm').addEventListener('submit', function(e) {
            let isValid = true;
            document.querySelectorAll('.error-message[id]').forEach(el => el.textContent = '');
            
            const currentPass = document.getElementById('currentPassword').value;
            const newPass = document.getElementById('newPassword').value;
            const confirmPass = document.getElementById('confirmPassword').value;
            
            if (!currentPass) {
                document.getElementById('currentPassError').textContent = 'Current password is required';
                isValid = false;
            }
            
            if (!newPass) {
                document.getElementById('newPassError').textContent = 'New password is required';
                isValid = false;
            } else if (newPass. length < 6) {
                document.getElementById('newPassError').textContent = 'Password must be at least 6 characters';
                isValid = false;
            }
            
            if (newPass !== confirmPass) {
                document.getElementById('confirmPassError').textContent = 'Passwords do not match';
                isValid = false;
            }
            
            if (!isValid) e.preventDefault();
        });
    </script>
</body>
</html>