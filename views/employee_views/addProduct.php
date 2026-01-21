<?php
session_start();
if (!isset($_SESSION['userId']) || $_SESSION['role'] != 2) {
    header("Location: ../login.php");
    exit();
}

require_once("../../models/categoryModel.php");
$categories = getAllCategories();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product - GadgetGrid Employee</title>
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
            <li><a href="manageProducts.php" class="active"> Products</a></li>
            <li><a href="manageStock.php"> Stock Management</a></li>
            <li><a href="manageOffers.php"> Offers</a></li>
            <li><a href="profile.php"> Profile</a></li>
            <li><a href="changePassword.php"> Change Password</a></li>
        </ul>
    </div>
    
    <div class="main-content">
        <div class="header">
            <h1>Add New Product</h1>
            <div class="header-user">
                <span>Welcome, <?php echo htmlspecialchars($_SESSION['userName']); ?></span>
                <a href="../logout. php" class="btn-logout">Logout</a>
            </div>
        </div>
        
        <div class="content-box" style="max-width: 700px;">
            <?php if (isset($_GET["genErr"])): ?>
                <div class="general-error"><?php echo htmlspecialchars($_GET["genErr"]); ?></div>
            <?php endif; ?>
            
            <form action="../../controllers/productControl.php" method="POST" id="productForm">
                <input type="hidden" name="action" value="add">
                
                <div class="form-group">
                    <label for="categoryId">Category *</label>
                    <select id="categoryId" name="categoryId">
                        <option value="">-- Select Category --</option>
                        <?php foreach ($categories as $cat): ?>
                            <option value="<?php echo $cat['categoryId']; ?>"><?php echo htmlspecialchars($cat['categoryName']); ?></option>
                        <?php endforeach; ?>
                    </select>
                    <?php if (isset($_GET["categoryErr"])): ?>
                        <span class="error-message"><?php echo htmlspecialchars($_GET["categoryErr"]); ?></span>
                    <?php endif; ?>
                    <span class="error-message" id="categoryError"></span>
                </div>
                
                <div class="form-group">
                    <label for="productName">Product Name *</label>
                    <input type="text" id="productName" name="productName" placeholder="e.g., iPhone 15 Pro">
                    <?php if (isset($_GET["nameErr"])): ?>
                        <span class="error-message"><?php echo htmlspecialchars($_GET["nameErr"]); ?></span>
                    <?php endif; ?>
                    <span class="error-message" id="nameError"></span>
                </div>
                
                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea id="description" name="description" rows="3" placeholder="Product description"></textarea>
                </div>
                
                <div class="form-group">
                    <label for="specifications">Specifications</label>
                    <textarea id="specifications" name="specifications" rows="3" placeholder="Product specifications (e.g., RAM, Storage, etc.)"></textarea>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="price">Price ($) *</label>
                        <input type="number" id="price" name="price" step="0.01" min="0" placeholder="0.00">
                        <?php if (isset($_GET["priceErr"])): ?>
                            <span class="error-message"><?php echo htmlspecialchars($_GET["priceErr"]); ?></span>
                        <?php endif; ?>
                        <span class="error-message" id="priceError"></span>
                    </div>
                    
                    <div class="form-group">
                        <label for="quantity">Initial Quantity</label>
                        <input type="number" id="quantity" name="quantity" min="0" value="0" placeholder="0">
                    </div>
                </div>
                
                <div style="display: flex; gap: 10px;">
                    <button type="submit" class="btn btn-primary">Add Product</button>
                    <a href="manageProducts.php" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
    
    <script>
        document.getElementById('productForm').addEventListener('submit', function(e) {
            let isValid = true;
            document.querySelectorAll('.error-message[id]').forEach(el => el.textContent = '');
            
            if (!document.getElementById('categoryId').value) {
                document.getElementById('categoryError').textContent = 'Please select a category';
                isValid = false;
            }
            
            if (!document.getElementById('productName').value.trim()) {
                document.getElementById('nameError').textContent = 'Product name is required';
                isValid = false;
            }
            
            const price = parseFloat(document.getElementById('price').value);
            if (! price || price <= 0) {
                document.getElementById('priceError').textContent = 'Price must be greater than 0';
                isValid = false;
            }
            
            if (!isValid) e.preventDefault();
        });
    </script>
</body>
</html>