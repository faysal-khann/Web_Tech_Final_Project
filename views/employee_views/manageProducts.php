<?php
session_start();
if (!isset($_SESSION['userId']) || $_SESSION['role'] != 2) {
    header("Location: ../login.php");
    exit();
}

require_once("../../models/productModel.php");
$products = getAllProducts();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Products - GadgetGrid Employee</title>
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
            <li><a href="manageProducts.php" class="active">📦 Products</a></li>
            <li><a href="manageStock.php"> Stock Management</a></li>
            <li><a href="manageOffers.php"> Offers</a></li>
            <li><a href="profile.php"> Profile</a></li>
            <li><a href="changePassword.php"> Change Password</a></li>
        </ul>
    </div>
    
    <div class="main-content">
        <div class="header">
            <h1>Manage Products</h1>
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
            
            <div style="display:  flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                <h2 style="margin: 0; border: none; padding: 0;">Product List</h2>
                <a href="addProduct.php" class="btn btn-primary">+ Add New Product</a>
            </div>
            
            <?php if (empty($products)): ?>
                <p style="color:  #666; padding: 20px 0;">No products found.</p>
            <?php else: ?>
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Category</th>
                                <th>Price</th>
                                <th>Offer</th>
                                <th>Stock</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($products as $prod): ?>
                                <tr>
                                    <td><?php echo $prod['productId']; ?></td>
                                    <td><?php echo htmlspecialchars($prod['productName']); ?></td>
                                    <td><?php echo htmlspecialchars($prod['categoryName']); ?></td>
                                    <td>$<?php echo number_format($prod['price'], 2); ?></td>
                                    <td>
                                        <?php if ($prod['offerPercent'] > 0): ?>
                                            <span class="offer-badge"><?php echo $prod['offerPercent']; ?>% OFF</span>
                                        <?php else: ?>
                                            -
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if ($prod['quantity'] <= 10): ?>
                                            <span class="stock-low"><?php echo $prod['quantity']; ?> (Low)</span>
                                        <?php else: ?>
                                            <span class="stock-ok"><?php echo $prod['quantity']; ?></span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <div class="action-btns">
                                            <a href="updateProduct.php?productId=<?php echo $prod['productId']; ?>" class="btn btn-warning btn-sm">Edit</a>
                                            <form action="../../controllers/productControl.php" method="POST" style="display: inline;">
                                                <input type="hidden" name="action" value="delete">
                                                <input type="hidden" name="productId" value="<?php echo $prod['productId']; ?>">
                                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this product?');">Delete</button>
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