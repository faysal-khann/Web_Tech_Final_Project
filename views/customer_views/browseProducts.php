<?php
session_start();
if (!isset($_SESSION['userId']) || $_SESSION['role'] != 3) {
    header("Location: ../login.php");
    exit();
}

require_once("../../models/productModel.php");
require_once("../../models/categoryModel.php");
require_once("../../models/wishlistModel.php");

$categories = getAllCategories();
$searchTerm = isset($_GET['search']) ? trim($_GET['search']) : '';
$categoryFilter = isset($_GET['category']) ? intval($_GET['category']) : 0;

if (! empty($searchTerm)) {
    $products = searchProducts($searchTerm);
} elseif ($categoryFilter > 0) {
    $products = getProductsByCategory($categoryFilter);
} else {
    $products = getAllProducts();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Browse Products - GadgetGrid</title>
    <link rel="stylesheet" href="css/customer_styles.css">
</head>
<body>
    <nav class="navbar" >
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
    

    <div class="main-container">

        <div class="page-header">
            <h1>Browse Products</h1>
            <p>Discover our collection of premium tech accessories</p>
        </div>
        
        <?php if (isset($_GET["success"])): ?>
            <div class="success-message"><?php echo htmlspecialchars($_GET["success"]); ?></div>
        <?php endif; ?>
        
        <?php if (isset($_GET["genErr"])): ?>
            <div class="general-error"><?php echo htmlspecialchars($_GET["genErr"]); ?></div>
        <?php endif; ?>
        
        <div class="content-box">


            <form method="GET" class="search-box">
                <input type="text" name="search" placeholder="Search products..." value="<?php echo htmlspecialchars($searchTerm); ?>">
                <select name="category">
                    <option value="0">All Categories</option>
                    <?php foreach ($categories as $cat): ?>
                        <option value="<?php echo $cat['categoryId']; ?>" >
                            <?php echo htmlspecialchars($cat['categoryName']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <button type="submit" class="btn btn-primary"> Search</button>
                <?php if (!empty($searchTerm) || $categoryFilter > 0): ?>
                    <a href="browseProducts.php" class="btn btn-outline">Clear</a>
                <?php endif; ?>
            </form>

            
            
            <?php if (empty($products)): ?>
                <div class="empty-state">
                    <div class="empty-state-icon">🔍</div>
                    <h3>No products found</h3>
                    <p>Try adjusting your search or filter criteria</p>
                </div>
            <?php else: ?>
                <p style="color: #666; margin-bottom: 20px;"><?php echo count($products); ?> product(s) found</p>
                <div class="product-grid">
                    <?php foreach ($products as $prod): 
                        $finalPrice = $prod['price'];
                        if ($prod['offerPercent'] > 0) {
                            $finalPrice = $prod['price'] - ($prod['price'] * $prod['offerPercent'] / 100);
                        }
                        $inWishlist = isInWishlist($_SESSION['userId'], $prod['productId']);
                    ?>

                        <div class="product-card">
                            <div class="product-image">
                                

                                <img src="../../uploads/products/<?php echo $prod['image']; ?>" alt="<?php echo htmlspecialchars($prod['productName']); ?>" class="product-img" style="width: 200px; height: auto;">

                                <?php if ($prod['offerPercent'] > 0): ?>
                                    <span class="product-offer-badge"><?php echo $prod['offerPercent']; ?>% OFF</span>
                                <?php endif; ?>
                            </div>
                            <div class="product-info">
                                <div class="product-category"><?php echo htmlspecialchars($prod['categoryName']); ?></div>
                                <div class="product-name"><?php echo htmlspecialchars($prod['productName']); ?></div>
                                <div class="product-specs"><?php echo htmlspecialchars($prod['specifications'] ?? 'No specifications available'); ?></div>
                                <div class="product-price">
                                    <span class="price-current">$<?php echo number_format($finalPrice, 2); ?></span>
                                    <?php if ($prod['offerPercent'] > 0): ?>
                                        <span class="price-original">$<?php echo number_format($prod['price'], 2); ?></span>
                                    <?php endif; ?>
                                </div>
                                <div class="product-stock">
                                    <?php if ($prod['quantity'] > 10): ?>
                                        <span class="stock-available">✓ In Stock (<?php echo $prod['quantity']; ?> available)</span>
                                    <?php elseif ($prod['quantity'] > 0): ?>
                                        <span class="stock-low">⚠ Low Stock (<?php echo $prod['quantity']; ?> left)</span>
                                    <?php else: ?>
                                        <span class="stock-out">✗ Out of Stock</span>
                                    <?php endif; ?>
                                </div>


                                <div class="product-actions">
                                    <?php if ($prod['quantity'] > 0): ?>

                                        <form action="../../controllers/orderControl.php" method="POST" style="flex: 1;">
                                            <input type="hidden" name="productId" value="<?php echo $prod['productId']; ?>">
                                            <input type="hidden" name="quantity" value="1">
                                            <button type="submit" class="btn btn-primary btn-block" onclick="return confirm('Confirm purchase of this item?');"> Buy Now</button>
                                        </form>

                                    <?php else: ?>
                                        <button class="btn btn-outline btn-block" disabled>Out of Stock</button>
                                    <?php endif; ?>

                                    <form action="../../controllers/wishlistControl.php" method="POST">
                                        <input type="hidden" name="productId" value="<?php echo $prod['productId']; ?>">
                                        <input type="hidden" name="action" value="<?php echo $inWishlist ? 'remove' : 'add'; ?>">
                                        <button type="submit" class="btn <?php echo $inWishlist ?  'btn-danger' : 'btn-outline'; ?>" title="<?php echo $inWishlist ?  'Remove from Wishlist' : 'Add to Wishlist'; ?>">
                                            <?php echo $inWishlist ? '❤️' : '🤍'; ?>
                                        </button>
                                    </form>
                                    
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
