<?php
session_start();
if (!isset($_SESSION['userId']) || $_SESSION['role'] != 3) {
    header("Location: ../login.php");
    exit();
}

require_once("../../models/wishlistModel.php");
$wishlist = getWishlistByCustomer($_SESSION['userId']); //WishList Model
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Wishlist - GadgetGrid</title>
    <link rel="stylesheet" href="css/customer_styles.css">
</head>
<body>
    <nav class="navbar">
        <a href="home.php" class="navbar-brand">🔌 GadgetGrid</a>
        <ul class="navbar-menu">
            <li><a href="home. php">Dashboard</a></li>
            <li><a href="browseProducts.php">Browse Products</a></li>
            <li><a href="orderHistory.php">My Orders</a></li>
            <li><a href="wishlist.php" class="active">Wishlist</a></li>
            <li><a href="profile.php">Profile</a></li>
        </ul>
        <div class="navbar-user">
            <span>Hi, <?php echo htmlspecialchars($_SESSION['userName']); ?></span>
            <a href="../logout.php" class="btn-logout">Logout</a>
        </div>
    </nav>
    
    
    <div class="main-container">
        <div class="page-header">
            <h1>My Wishlist ❤️</h1>
            <p>Items you've saved for later</p>
        </div>
        
        <?php if (isset($_GET["success"])): ?>
            <div class="success-message"><?php echo htmlspecialchars($_GET["success"]); ?></div>
        <?php endif; ?>
        
        <?php if (isset($_GET["genErr"])): ?>
            <div class="general-error"><?php echo htmlspecialchars($_GET["genErr"]); ?></div>
        <?php endif; ?>
        
        <div class="content-box">
            <h2>Saved Items (<?php echo count($wishlist); ?>)</h2>
            
            <?php if (empty($wishlist)): ?>
                <div class="empty-state">
                    <div class="empty-state-icon">❤️</div>
                    <h3>Your wishlist is empty</h3>
                    <p>Save items you love while browsing our products! </p>
                    <a href="browseProducts.php" class="btn btn-primary" style="margin-top: 20px;">Browse Products</a>
                </div>
            <?php else: ?>
                <div class="product-grid">
                    <?php foreach ($wishlist as $item): 
                        $finalPrice = $item['price'];
                        if ($item['offerPercent'] > 0) {
                            $finalPrice = $item['price'] - ($item['price'] * $item['offerPercent'] / 100);
                        }
                    ?>
                        <div class="product-card">
                            <div class="product-image">
                                📱
                                <?php if ($item['offerPercent'] > 0): ?>
                                    <span class="product-offer-badge"><?php echo $item['offerPercent']; ?>% OFF</span>
                                <?php endif; ?>
                            </div>
                            <div class="product-info">
                                <div class="product-category"><?php echo htmlspecialchars($item['categoryName']); ?></div>
                                <div class="product-name"><?php echo htmlspecialchars($item['productName']); ?></div>
                                <div class="product-price">
                                    <span class="price-current">$<?php echo number_format($finalPrice, 2); ?></span>
                                    <?php if ($item['offerPercent'] > 0): ?>
                                        <span class="price-original">$<?php echo number_format($item['price'], 2); ?></span>
                                    <?php endif; ?>
                                </div>
                                <div class="product-stock">
                                    <?php if ($item['stock'] > 10): ?>
                                        <span class="stock-available">✓ In Stock</span>
                                    <?php elseif ($item['stock'] > 0): ?>
                                        <span class="stock-low">⚠ Low Stock (<?php echo $item['stock']; ?> left)</span>
                                    <?php else: ?>
                                        <span class="stock-out">✗ Out of Stock</span>
                                    <?php endif; ?>
                                </div>
                                <div class="product-actions">
                                    <?php if ($item['stock'] > 0): ?>
                                        <form action="../../controllers/orderControl.php" method="POST" style="flex:  1;">
                                            <input type="hidden" name="productId" value="<?php echo $item['productId']; ?>">
                                            <input type="hidden" name="quantity" value="1">
                                            <button type="submit" class="btn btn-primary btn-block" onclick="return confirm('Confirm purchase of this item?');">🛒 Buy Now</button>
                                        </form>
                                    <?php else: ?>
                                        <button class="btn btn-outline btn-block" disabled>Out of Stock</button>
                                    <?php endif; ?>
                                    <form action="../../controllers/wishlistControl.php" method="POST">
                                        <input type="hidden" name="productId" value="<?php echo $item['productId']; ?>">
                                        <input type="hidden" name="action" value="remove">
                                        <button type="submit" class="btn btn-danger" title="Remove from Wishlist">🗑️</button>
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