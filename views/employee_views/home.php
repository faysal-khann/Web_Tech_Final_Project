<?php
session_start();
if (!isset($_SESSION['userId']) || $_SESSION['role'] != 2) {
    header("Location:  ../login.php");
    exit();
}

require_once("../../models/userModel.php");
require_once("../../models/productModel.php");
require_once("../../models/categoryModel.php");

$totalCustomers = count(getAllCustomers());
$totalProducts = count(getAllProducts());
$totalCategories = count(getAllCategories());
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Dashboard - GadgetGrid</title>
    <link rel="stylesheet" href="css/employee_styles.css">
</head>
<body>
    <div class="sidebar">
        <div class="sidebar-header">
            <h2>🔌 GadgetGrid</h2>
            <p>Employee Panel</p>
        </div>
        <ul class="sidebar-menu">
            <li><a href="home.php" class="active">📊 Dashboard</a></li>
            <li><a href="manageCustomers.php">👥 Customers</a></li>
            <li><a href="manageProducts.php">📦 Products</a></li>
            <li><a href="manageStock.php">📥 Stock Management</a></li>
            <li><a href="manageOffers.php">🏷️ Offers</a></li>
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
                <div class="card-icon green">👤</div>
                <h3><?php echo $totalCustomers; ?></h3>
                <p>Total Customers</p>
            </div>
            <div class="card">
                <div class="card-icon blue">📦</div>
                <h3><?php echo $totalProducts; ?></h3>
                <p>Total Products</p>
            </div>
            <div class="card">
                <div class="card-icon purple">📁</div>
                <h3><?php echo $totalCategories; ?></h3>
                <p>Categories</p>
            </div>
        </div>
        
        <div class="content-box">
            <h2>Quick Actions</h2>
            <div style="display: flex; gap: 15px; flex-wrap: wrap;">
                <a href="addCustomer.php" class="btn btn-primary">+ Add Customer</a>
                <a href="addProduct.php" class="btn btn-success">+ Add Product</a>
                <a href="manageStock.php" class="btn btn-info">Manage Stock</a>
                <a href="manageOffers.php" class="btn btn-warning">Manage Offers</a>
            </div>
        </div>
    </div>
</body>
</html>