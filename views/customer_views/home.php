<?php
session_start();
if (!isset($_SESSION['userId']) || $_SESSION['role'] != 3) {
    header("Location:  ../login.php");
    exit();
}

require_once("../../models/productModel.php");
require_once("../../models/orderModel.php");
require_once("../../models/wishlistModel.php");

$products = getAllProducts(); //Product Model
$orders = getOrdersByCustomer($_SESSION['userId']); //Order model
$wishlist = getWishlistByCustomer($_SESSION['userId']); //Wishlist model
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - GadgetGrid</title>
    <link rel="stylesheet" href="css/customer_styles.css">
</head>
<body>

    <nav class="navbar">
        <a href="home.php" class="navbar-brand">🔌 GadgetGrid</a>
        <ul class="navbar-menu">
            <li><a href="home.php" class="active">Dashboard</a></li>
            <li><a href="browseProducts.php">Browse Products</a></li>
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
            <h1>Welcome back, <?php echo htmlspecialchars(explode(' ', $_SESSION['userName'])[0]); ?>!</h1>
            <p>Explore the latest tech accessories and gadgets</p>
        </div>
        

        <div class="dashboard-cards">
            <div class="card">
                <div class="card-icon purple">📦</div>
                <h3><?php echo count($products); ?></h3>
                <p>Products Available</p>
            </div>
            <div class="card">
                <div class="card-icon pink">🛒</div>
                <h3><?php echo count($orders); ?></h3>
                <p>My Orders</p>
            </div>
            <div class="card">
                <div class="card-icon green">❤️</div>
                <h3><?php echo count($wishlist); ?></h3>
                <p>Wishlist Items</p>
            </div>
        </div>
        

        <div class="content-box">
            <h2>Quick Actions</h2>
            <div style="display: flex; gap: 15px; flex-wrap: wrap;">
                <a href="browseProducts.php" class="btn btn-primary"> Browse Products</a>
                <a href="orderHistory.php" class="btn btn-outline"> View Order History</a>
                <a href="wishlist.php" class="btn btn-outline"> My Wishlist</a>
                <a href="profile.php" class="btn btn-outline"> Edit Profile</a>
            </div>
        </div>
        

        <div class="content-box">
            <h2>Featured Products</h2>

            <?php if (empty($products)): ?>
                <div class="empty-state">
                    <div class="empty-state-icon"></div>
                    <h3>No products available</h3>
                    <p>Check back later for new arrivals! </p>
                </div>
            <?php else: ?>

                <div class="product-grid">
                    <?php foreach (array_slice($products, 0, 4) as $prod): 
                        $finalPrice = $prod['price'];
                        if ($prod['offerPercent'] > 0) {
                            $finalPrice = $prod['price'] - ($prod['price'] * $prod['offerPercent'] / 100);
                        }
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
                                <div class="product-price">
                                    <span class="price-current">$<?php echo number_format($finalPrice, 2); ?></span>
                                    <?php if ($prod['offerPercent'] > 0): ?>
                                        <span class="price-original">$<?php echo number_format($prod['price'], 2); ?></span>
                                    <?php endif; ?>
                                </div>
                                <a href="browseProducts.php" class="btn btn-primary btn-block">View Details</a>
                            </div>
                        </div>
                        
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>