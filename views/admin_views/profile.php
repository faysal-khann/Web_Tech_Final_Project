<?php
session_start();
if (!isset($_SESSION['userId']) || $_SESSION['role'] != 1) {
    header("Location: ../login.php");
    exit();
}

require_once("../../models/userModel.php");
$user = getUserById($_SESSION['userId']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile - GadgetGrid Admin</title>
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
            <li><a href="employeeApproval.php">👥 Employee Approval</a></li>
            <li><a href="viewAllUsers. php">📋 All Users</a></li>
            <li><a href="manageCategories.php">📁 Categories</a></li>
            <li><a href="stockLogs. php">📦 Stock Logs</a></li>
            <li><a href="profile.php" class="active">⚙️ Profile</a></li>
            <li><a href="changePassword.php">🔐 Change Password</a></li>
        </ul>
    </div>
    
    <div class="main-content">
        <div class="header">
            <h1>My Profile</h1>
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
            
            <form action="../../controllers/profileControl.php" method="POST" id="profileForm">
                <input type="hidden" name="action" value="update">
                
                <div class="form-group">
                    <label for="email">Email Address</label>
                    <input type="email" id="email" value="<?php echo htmlspecialchars($user['email']); ?>" readonly style="background: #f5f5f5;">
                </div>
                
                <div class="form-group">
                    <label for="firstName">First Name *</label>
                    <input type="text" id="firstName" name="firstName" value="<?php echo htmlspecialchars($user['firstName']); ?>">
                    <?php if (isset($_GET["firstNameErr"])): ?>
                        <span class="error-message"><?php echo htmlspecialchars($_GET["firstNameErr"]); ?></span>
                    <?php endif; ?>
                    <span class="error-message" id="firstNameError"></span>
                </div>
                
                <div class="form-group">
                    <label for="lastName">Last Name *</label>
                    <input type="text" id="lastName" name="lastName" value="<?php echo htmlspecialchars($user['lastName']); ?>">
                    <?php if (isset($_GET["lastNameErr"])): ?>
                        <span class="error-message"><?php echo htmlspecialchars($_GET["lastNameErr"]); ?></span>
                    <?php endif; ?>
                    <span class="error-message" id="lastNameError"></span>
                </div>
                
                <div class="form-group">
                    <label for="phone">Phone Number</label>
                    <input type="text" id="phone" name="phone" value="<?php echo htmlspecialchars($user['phone'] ?? ''); ?>">
                </div>
                
                <div class="form-group">
                    <label for="address">Address</label>
                    <textarea id="address" name="address" rows="3"><?php echo htmlspecialchars($user['address'] ?? ''); ?></textarea>
                </div>
                
                <button type="submit" class="btn btn-primary">Update Profile</button>
            </form>
            
            <hr style="margin:  30px 0;">
            
           
            <form action="../../controllers/profileControl. php" method="POST" onsubmit="return confirm('Are you sure you want to delete your account?  This action cannot be undone.');">
                <input type="hidden" name="action" value="delete">
                <button type="submit" class="btn btn-danger">Delete Account</button>
            </form>
        </div>
    </div>
    
    <script>
        document.getElementById('profileForm').addEventListener('submit', function(e) {
            let isValid = true;
            document.getElementById('firstNameError').textContent = '';
            document.getElementById('lastNameError').textContent = '';
            
            if (! document.getElementById('firstName').value.trim()) {
                document.getElementById('firstNameError').textContent = 'First name is required';
                isValid = false;
            }
            
            if (!document. getElementById('lastName').value.trim()) {
                document.getElementById('lastNameError').textContent = 'Last name is required';
                isValid = false;
            }
            
            if (!isValid) e.preventDefault();
        });
    </script>
</body>
</html>