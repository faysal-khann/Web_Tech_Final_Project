<?php
session_start();
if (!isset($_SESSION['userId']) || $_SESSION['role'] != 1) {
    header("Location:  ../login.php");
    exit();
}

require_once("../../models/userModel.php");
require_once("../../models/productModel.php");
require_once("../../models/categoryModel.php");

$pendingEmployees = count(getPendingEmployees());
$totalCustomers = count(getAllCustomers());
$totalEmployees = count(getAllEmployees());
$totalProducts = count(getAllProducts());
$totalCategories = count(getAllCategories());
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - GadgetGrid</title>
    <link rel="stylesheet" href="css/admin_styles.css">
</head>
<body>
    <div class="sidebar">
        <div class="sidebar-header">
            <h2>🔌 GadgetGrid</h2>
            <p>Admin Panel</p>
        </div>
        <ul class="sidebar-menu">
            <li><a href="home.php" class="active">📊 Dashboard</a></li>
            <li><a href="employeeApproval.php">👥 Employee Approval</a></li>
            <li><a href="viewAllUsers.php">📋 All Users</a></li>
            <li><a href="manageCategories.php">📁 Categories</a></li>
            <li><a href="stockLogs.php">📦 Stock Logs</a></li>
            <li><a href="profile.php">⚙️ Profile</a></li>
            <li><a href="changePassword.php">🔐 Change Password</a></li>
        </ul>
    </div>
    
    <div class="main-content">
        <div class="header">
            <h1>Dashboard</h1>
            <div class="header-user">
                <span>Welcome, <?php echo htmlspecialchars($_SESSION['userName']); ?></span>
                <a href="../logout.php" class="btn-logout">Logout</a>
            </div>
        </div>
        
        <div class="dashboard-cards">
            <div class="card">
                <div class="card-icon orange">⏳</div>
                <h3><?php echo $pendingEmployees; ?></h3>
                <p>Pending Approvals</p>
            </div>
            <div class="card">
                <div class="card-icon blue">💼</div>
                <h3><?php echo $totalEmployees; ?></h3>
                <p>Active Employees</p>
            </div>
            <div class="card">
                <div class="card-icon green">👤</div>
                <h3><?php echo $totalCustomers; ?></h3>
                <p>Total Customers</p>
            </div>
            <div class="card">
                <div class="card-icon purple">📦</div>
                <h3><?php echo $totalProducts; ?></h3>
                <p>Total Products</p>
            </div>
        </div>
        
        <div class="content-box">
            <h2>Quick Actions</h2>
            <div style="display: flex; gap: 15px; flex-wrap: wrap;">
                <a href="employeeApproval.php" class="btn btn-primary">Review Employee Applications</a>
                <a href="manageCategories.php" class="btn btn-success">Manage Categories</a>
                <a href="viewAllUsers.php" class="btn btn-primary">View All Users</a>
                <a href="profile.php">⚙️ Profile</a>
            </div>
        </div>
    </div>
</body>
</html>