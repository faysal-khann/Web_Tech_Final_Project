<?php
session_start();
if (!isset($_SESSION['userId']) || $_SESSION['role'] != 3) {
    header("Location: ../login.php");
    exit();
}

require_once("../../models/orderModel.php");
$orders = getOrdersByCustomer($_SESSION['userId']); //Order Model
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order History - GadgetGrid</title>
    <link rel="stylesheet" href="css/customer_styles.css">
</head>
<body>

    <nav class="navbar">
        <a href="home.php" class="navbar-brand">🔌 GadgetGrid</a>
        <ul class="navbar-menu">
            <li><a href="home.php">Dashboard</a></li>
            <li><a href="browseProducts.php">Browse Products</a></li>
            <li><a href="orderHistory.php" class="active">My Orders</a></li>
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
            <h1>Order History</h1>
            <p>View your past purchases</p>
        </div>
        
        <?php if (isset($_GET["success"])): ?>
            <div class="success-message"><?php echo htmlspecialchars($_GET["success"]); ?></div>
        <?php endif; ?>
        

        <div class="content-box">
            <h2>My Orders (<?php echo count($orders); ?>)</h2>
            
            <?php if (empty($orders)): ?>
                <div class="empty-state">
                    <div class="empty-state-icon">🛒</div>
                    <h3>No orders yet</h3>
                    <p>Start shopping to see your order history here!</p>
                    <a href="browseProducts.php" class="btn btn-primary" style="margin-top: 20px;">Browse Products</a>
                </div>
            <?php else: ?>


                <div class="table-container">
                    <table>
                            <tr>
                                <th>Order ID</th>
                                <th>Product</th>
                                <th>Quantity</th>
                                <th>Unit Price</th>
                                <th>Total</th>
                                <th>Status</th>
                                <th>Date</th>
                            </tr>
                        
                            <?php foreach ($orders as $order): ?>
                                <tr>
                                    <td>#<?php echo $order['orderId']; ?></td>
                                    <td><?php echo htmlspecialchars($order['productName']); ?></td>
                                    <td><?php echo $order['quantity']; ?></td>
                                    <td>$<?php echo number_format($order['unitPrice'], 2); ?></td>
                                    <td style="font-weight: 600; color: #667eea;">$<?php echo number_format($order['totalPrice'], 2); ?></td>
                                    <td>
                                        <?php
                                        $badgeClass = 'badge-pending';
                                        if ($order['status'] == 'completed') $badgeClass = 'badge-completed';
                                        elseif ($order['status'] == 'cancelled') $badgeClass = 'badge-cancelled';
                                        ?>
                                        <span class="badge <?php echo $badgeClass; ?>"><?php echo ucfirst($order['status']); ?></span>
                                    </td>
                                    <td><?php echo date('M d, Y', strtotime($order['created_at'])); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        
                    </table>
                </div>


                
                <?php 
                $totalSpent = array_sum(array_column($orders, 'totalPrice'));
                ?>
                <div style="margin-top: 20px; padding: 20px; background: #f8f9fa; border-radius: 8px;">
                    <strong>Total Amount Spent: </strong> 
                    <span style="font-size: 24px; color: #667eea; font-weight: 700;">$<?php echo number_format($totalSpent, 2); ?></span>
                </div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>