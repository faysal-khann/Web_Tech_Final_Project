<?php
session_start();
if (!isset($_SESSION['userId']) || $_SESSION['role'] != 3) {
    header("Location: ../login. php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Password - GadgetGrid Customer</title>
    <link rel="stylesheet" href="css/employee_styles.css">
</head>

<body>
    
    <section class="welcome-section">
      <nav class="navbar">
        <a href="home.php" class="navbar-brand">🔌 GadgetGrid</a>
        <ul class="navbar-menu">
            <li><a href="home.php">Dashboard</a></li>
            <li><a href="browseProducts.php" class="active">Browse Products</a></li>
            <li><a href="orderHistory.php">My Orders</a></li>
            <li><a href="wishlist.php">Wishlist</a></li>
            <li><a href="profile.php">Profile</a></li>
        </ul>
        <div class="navbar-user">
            <span>Hi, <?php echo htmlspecialchars($_SESSION['userName']); ?></span>
            <a href="../logout.php" class="btn-logout">Logout</a>
        </div>
      </nav>
    </section>
    
    <div class="main-content">
        <div class="header">
            <h1>Change Password</h1>
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
    
    
</body>
</html>