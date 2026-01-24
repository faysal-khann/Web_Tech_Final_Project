<?php
session_start();
if (!isset($_SESSION['userId']) || $_SESSION['role'] != 1) {
    header("Location: ../login. php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Category - GadgetGrid Admin</title>
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
            <li><a href="manageCategories.php" class="active">📁 Categories</a></li>
            <li><a href="stockLogs.php">📦 Stock Logs</a></li>
            <li><a href="profile.php">⚙️ Profile</a></li>
            <li><a href="changePassword.php">🔐 Change Password</a></li>
        </ul>
    </div>
    
    <div class="main-content">
        <div class="header">
            <h1>Add New Category</h1>
            <div class="header-user">
                <span>Welcome, <?php echo htmlspecialchars($_SESSION['userName']); ?></span>
                <a href="../logout.php" class="btn-logout">Logout</a>
            </div>
        </div>
        
        <div class="content-box" style="max-width: 600px;">
            <?php if (isset($_GET["genErr"])): ?>
                <div class="general-error"><?php echo htmlspecialchars($_GET["genErr"]); ?></div>
            <?php endif; ?>
            
            <form action="../../controllers/categoryControl.php" method="POST" id="categoryForm">
                <input type="hidden" name="action" value="add">
                
                <div class="form-group">
                    <label for="categoryName">Category Name *</label>
                    <input type="text" id="categoryName" name="categoryName" placeholder="e.g., VR Headsets">
                    <?php if (isset($_GET["nameErr"])): ?>
                        <span class="error-message"><?php echo htmlspecialchars($_GET["nameErr"]); ?></span>
                    <?php endif; ?>
                    <span class="error-message" id="nameError"></span>
                </div>
                
                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea id="description" name="description" rows="4" placeholder="Enter category description"></textarea>
                </div>
                
                <div style="display: flex; gap:  10px;">
                    <button type="submit" class="btn btn-primary">Add Category</button>
                    <a href="manageCategories.php" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
    
    <script>
        document. getElementById('categoryForm').addEventListener('submit', function(e) {
            document.getElementById('nameError').textContent = '';
            
            if (! document.getElementById('categoryName').value.trim()) {
                document.getElementById('nameError').textContent = 'Category name is required';
                e.preventDefault();
            }
        });
    </script>
</body>
</html>