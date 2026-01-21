<?php
session_start();
if (!isset($_SESSION['userId']) || $_SESSION['role'] != 2) {
    header("Location: ../login. php");
    exit();
}

require_once("../../models/productModel.php");
require_once("../../models/categoryModel.php");

$productId = isset($_GET['productId']) ? intval($_GET['productId']) : 0;
$product = getProductById($productId);
$categories = getAllCategories();

if (!$product) {
    header("Location: manageProducts.php? genErr=Product not found");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Product - GadgetGrid Employee</title>
    <link rel="stylesheet" href="css/employee_styles.css">
</head>
<body>
    <div class="sidebar">
        <div class="sidebar-header">
            <h2>🔌 GadgetGrid</h2>
            <p>Employee Panel</p>
        </div>
        <ul class="sidebar-menu">
            <li><a href="home.php">📊 Dashboard</a></li>
            <li><a href="manageCustomers.php">👥 Customers</a></li>
            <li><a href="manageProducts.php" class="active">📦 Products</a></li>
            <li><a href="manageStock.php">📥 Stock Management</a></li>
            <li><a href="manageOffers. php">🏷️ Offers</a></li>
            <li><a href="profile. php">⚙️ Profile</a></li>
            <li><a href="changePassword. php">🔐 Change Password</a></li>
        </ul>
    </div>
    
    <div class="main-content">
        <div class="header">
            <h1>Update Product</h1>
            <div class="header-user">
                <span>Welcome, <?php echo htmlspecialchars($_SESSION['userName']); ?></span>
                <a href="../logout.php" class="btn-logout">Logout</a>
            </div>
        </div>
        
        <div class="content-box" style="max-width: 700px;">
            <?php if (isset($_GET["genErr"])): ?>
                <div class="general-error"><?php echo htmlspecialchars($_GET["genErr"]); ?></div>
            <?php endif; ?>
            
            <form action="../../controllers/productControl.php" method="POST" id="productForm">
                <input type="hidden" name="action" value="update">
                <input type="hidden" name="productId" value="<?php echo $product['productId']; ?>">
                
                <div class="form-group">
                    <label for="categoryId">Category *</label>
                    <select id="categoryId" name="categoryId">
                        <?php foreach ($categories as $cat): ?>
                            <option value="<?php echo $cat['categoryId']; ?>" <?php echo ($cat['categoryId'] == $product['categoryId']) ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($cat['categoryName']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="productName">Product Name *</label>
                    <input type="text" id="productName" name="productName" value="<?php echo htmlspecialchars($product['productName']); ?>">
                    <span class="error-message" id="nameError"></span>
                </div>
                
                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea id="description" name="description" rows="3"><?php echo htmlspecialchars($product['description'] ?? ''); ?></textarea>
                </div>
                
                <div class="form-group">
                    <label for="specifications">Specifications</label>
                    <textarea id="specifications" name="specifications" rows="3"><?php echo htmlspecialchars($product['specifications'] ?? ''); ?></textarea>
                </div>
                
                <div class="form-group">
                    <label for="price">Price ($) *</label>
                    <input type="number" id="price" name="price" step="0.01" min="0" value="<?php echo $product['price']; ?>">
                    <span class="error-message" id="priceError"></span>
                </div>
                
                <p style="color: #666; margin-bottom: 20px;">
                    <strong>Current Stock: </strong> <?php echo $product['quantity']; ?> units 
                    (Use <a href="manageStock.php">Stock Management</a> to adjust stock)
                </p>
                
                <div style="display: flex; gap: 10px;">
                    <button type="submit" class="btn btn-primary">Update Product</button>
                    <a href="manageProducts.php" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
    
    <script>
        document.getElementById('productForm').addEventListener('submit', function(e) {
            let isValid = true;
            document.querySelectorAll('.error-message[id]').forEach(el => el.textContent = '');
            
            if (!document.getElementById('productName').value.trim()) {
                document.getElementById('nameError').textContent = 'Product name is required';
                isValid = false;
            }
            
            const price = parseFloat(document.getElementById('price').value);
            if (!price || price <= 0) {
                document.getElementById('priceError').textContent = 'Price must be greater than 0';
                isValid = false;
            }
            
            if (! isValid) e.preventDefault();
        });
    </script>
</body>
</html>