<?php
session_start();
if (!isset($_SESSION['userId']) || $_SESSION['role'] != 2) {
    header("Location: ../login.php");
    exit();
}

require_once("../../models/productModel.php");
require_once("../../models/stockModel.php");

$products = getAllProducts();
$myLogs = getStockLogsByEmployee($_SESSION['userId']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stock Management - GadgetGrid Employee</title>
    <link rel="stylesheet" href="css/employee_styles.css">
</head>
<body>
    <div class="sidebar">
        <div class="sidebar-header">
            <h2>🔌 GadgetGrid</h2>
            <p>Employee Panel</p>
        </div>
        <ul class="sidebar-menu">
            <li><a href="home.php"> Dashboard</a></li>
            <li><a href="manageCustomers.php"> Customers</a></li>
            <li><a href="manageProducts.php"> Products</a></li>
            <li><a href="manageStock.php" class="active"> Stock Management</a></li>
            <li><a href="manageOffers.php"> Offers</a></li>
            <li><a href="profile.php"> Profile</a></li>
            <li><a href="changePassword.php"> Change Password</a></li>
        </ul>
    </div>
    
    <div class="main-content">
        <div class="header">
            <h1>Stock Management</h1>
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
            
            <h2>Add/Remove Stock</h2>
            
            <form action="../../controllers/stockControl.php" method="POST" id="stockForm">
                <div class="form-row">
                    <div class="form-group">
                        <label for="productId">Select Product *</label>
                        <select id="productId" name="productId" required>
                            <option value="">-- Select Product --</option>
                            <?php foreach ($products as $prod): ?>
                                <option value="<?php echo $prod['productId']; ?>">
                                    <?php echo htmlspecialchars($prod['productName']); ?> (Stock: <?php echo $prod['quantity']; ?>)
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="action">Action *</label>
                        <select id="action" name="action" required>
                            <option value="stock_in">📥 Stock In (Add)</option>
                            <option value="stock_out">📤 Stock Out (Remove)</option>
                        </select>
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="quantity">Quantity *</label>
                        <input type="number" id="quantity" name="quantity" min="1" value="1" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="notes">Notes</label>
                        <input type="text" id="notes" name="notes" placeholder="Optional notes">
                    </div>
                </div>
                
                <button type="submit" class="btn btn-primary">Update Stock</button>
            </form>
        </div>
        
        <div class="content-box">
            <h2>My Recent Stock Activities</h2>
            
           