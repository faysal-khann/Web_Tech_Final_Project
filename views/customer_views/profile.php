<?php
session_start();
if (!isset($_SESSION['userId']) || $_SESSION['role'] != 3) {
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
    <title>My Profile - GadgetGrid</title>
    <link rel="stylesheet" href="css/customer_styles.css">
</head>
<body>

<header>
        <nav class="navbar">
        <a href="home.php" class="navbar-brand">🔌 GadgetGrid</a>
        <ul class="navbar-menu">
            <li><a href="home.php">Dashboard</a></li>
            <li><a href="browseProducts.php">Browse Products</a></li>
            <li><a href="orderHistory.php">My Orders</a></li>
            <li><a href="wishlist.php">Wishlist</a></li>
            <li><a href="profile.php" class="active">Profile</a></li>
        </ul>
        <div class="navbar-user">
            <span>Hi, <?php echo htmlspecialchars($_SESSION['userName']); ?></span>
            <a href="../logout.php" class="btn-logout">Logout</a>
        </div>
    </nav>
</header>
    
    
    <div class="main-container">
        <div class="page-header">
            <h1>My Profile</h1>
            <p>Manage your account information</p>
        </div>
        
        <div class="content-box" style="max-width: 600px;">

            <?php if (isset($_GET["success"])): ?>
                <div class="success-message"><?php echo htmlspecialchars($_GET["success"]); ?></div>
            <?php endif; ?>
            
            <?php if (isset($_GET["genErr"])): ?>
                <div class="general-error"><?php echo htmlspecialchars($_GET["genErr"]); ?></div>
            <?php endif; ?>
            



            <form action="../../controllers/profileControl.php" method="POST" id="profileForm"  onsubmit="return confirm('Are you sure you want to update your account? ');">
                <input type="hidden" name="action" value="update">
                
                <div class="form-group">
                    <label for="email">Email Address</label>
                    <input type="email" id="email" value="<?php echo htmlspecialchars($user['email']); ?>" readonly style="background: #f5f5f5;">
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="firstName">First Name *</label>
                        <input type="text" id="firstName" name="firstName" value="<?php echo htmlspecialchars($user['firstName']); ?>">
                        <span class="error-message" id="firstNameError"></span>
                    </div>
                    
                    <div class="form-group">
                        <label for="lastName">Last Name *</label>
                        <input type="text" id="lastName" name="lastName" value="<?php echo htmlspecialchars($user['lastName']); ?>">
                        <span class="error-message" id="lastNameError"></span>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="phone">Phone Number</label>
                    <input type="text" id="phone" name="phone" value="<?php echo htmlspecialchars($user['phone'] ?? ''); ?>">
                </div>
                
                <div class="form-group">
                    <label for="address">Shipping Address</label>
                    <textarea id="address" name="address" rows="3"><?php echo htmlspecialchars($user['address'] ?? ''); ?></textarea>
                </div>
                
                <button type="submit" class="btn btn-primary">Update Profile</button>
            </form>
            
            <hr style="margin:  30px 0; border: none; border-top: 1px solid #e1e1e1;">
            
            <p style="margin-bottom: 15px;"><a href="changePassword.php" style="color: #667eea;">🔐 Change Password</a></p>
            
            <h3 style="color: #e74c3c; margin-bottom: 15px;">Danger Zone</h3>
            <form action="../../controllers/profileControl. php" method="POST" onsubmit="return confirm('Are you sure you want to delete your account?  This action cannot be undone.');">
                <input type="hidden" name="action" value="delete">
                <button type="submit" class="btn btn-danger">Delete My Account</button>
            </form>
        </div>
    </div>
    
    
</body>
</html>