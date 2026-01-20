<?php
session_start();
if (!isset($_SESSION['userId']) || $_SESSION['role'] != 3) {
    header("Location:  ../login.php");
    exit();
}

require_once("../../models/productModel.php");
require_once("../../models/orderModel.php");
require_once("../../models/wishlistModel.php");

$products = getAllProducts();  //Product Model
$orders = getOrdersByCustomer($_SESSION['userId']); //Order model
$wishlist = getWishlistByCustomer($_SESSION['userId']);  //Wishlist model
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - GadgetGrid</title>
</head>

<body>

<header>
    Header:
    <nav>
        <a href="home.php">🔌 GadgetGrid</a>
        <ul>
            <li><a href="home.php" class="active">Dashboard</a></li>
            <li><a href="browseProducts.php">Browse Products</a></li>
            <li><a href="orderHistory.php">My Orders</a></li>
            <li><a href="wishlist.php">Wishlist</a></li>
            <li><a href="profile.php">Profile</a></li>
        </ul>
        <div>
            <span>Hi, <?php echo htmlspecialchars($_SESSION['userName']); ?></span>
            <a href="../logout.php">Logout</a>
        </div>
    </nav><br>

    //Header
</header>




<main>
    <div>
        <div>
            <h1>Welcome back, <?php echo htmlspecialchars(explode(' ', $_SESSION['userName'])[0]); ?>! 👋</h1>
            <p>Explore the latest tech accessories and gadgets</p>
        </div>
        
        <div>
            <div>
                <div>📦</div>
                <h3><?php echo count($products); ?></h3>
                <p>Products Available</p>
            </div>
            <div>
                <div>🛒</div>
                <h3><?php echo count($orders); ?></h3>
                <p>My Orders</p>
            </div>
            <div>
                <div>❤️</div>
                <h3><?php echo count($wishlist); ?></h3>
                <p>Wishlist Items</p>
            </div>
        </div>

        <div>
            <h2>Quick Actions</h2>
            <div>
                <a href="browseProducts.php">🛍️ Browse Products</a>
                <a href="orderHistory.php">📋 View Order History</a>
                <a href="wishlist.php">❤️ My Wishlist</a>
                <a href="profile.php">⚙️ Edit Profile</a>
            </div>
        </div>

        <div>
            <h2>Featured Products</h2>

            <?php if (empty($products)): ?>
                <div>
                    <div>📦</div>
                    <h3>No products available</h3>
                    <p>Check back later for new arrivals!</p>
                </div>

            <?php else: ?>
                
                <div >    


                    <?php foreach (array_slice($products, 0, 4) as $prod): 
                        $finalPrice = $prod['price'];
                        if ($prod['offerPercent'] > 0) {
                            $finalPrice = $prod['price'] - ($prod['price'] * $prod['offerPercent'] / 100);
                        }
                    ?>


                        <div>
                            <div>
                                📱
                                <?php if ($prod['offerPercent'] > 0): ?>
                                    <span><?php echo $prod['offerPercent']; ?>% OFF</span>
                                <?php endif; ?>
                            </div>

                            <div>
                                <div><?php echo htmlspecialchars($prod['categoryName']); ?></div>
                                <div><?php echo htmlspecialchars($prod['productName']); ?></div>
                                <div>
                                    <span>$<?php echo number_format($finalPrice, 2); ?></span>
                                    <?php if ($prod['offerPercent'] > 0): ?>
                                        <span>$<?php echo number_format($prod['price'], 2); ?></span>
                                    <?php endif; ?>
                                </div>
                                <a href="browseProducts.php">View Details</a>
                            </div>
                        </div>
                        <br>
                        <br>
                        <br>




                    <?php endforeach; ?>

                </div>
            <?php endif; ?>
        </div>
    </div>
</main>
</body>
</html>