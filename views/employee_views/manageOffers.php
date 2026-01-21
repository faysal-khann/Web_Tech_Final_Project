<?php
session_start();
if (!isset($_SESSION['userId']) || $_SESSION['role'] != 2) {
    header("Location: ../login. php");
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
    <title>Manage Offers - GadgetGrid Employee</title>
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
            <li><a href="manageProducts.php">📦 Products</a></li>
            <li><a href="manageStock.php">📥 Stock Management</a></li>
            <li><a href="manageOffers.php" class="active">🏷️ Offers</a></li>
            <li><a href="profile.php">⚙️ Profile</a></li>
            <li><a href="changePassword.php">🔐 Change Password</a></li>
        </ul>
    </div>
    
    <div class="main-content">
        <div class="header">
            <h1>Manage Offers</h1>
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
            
            <h2>Product Offers & Pricing</h2>
            
            <?php if (empty($products)): ?>
                <p style="color: #666; padding: 20px 0;">No products found.</p>
            <?php else: ?>
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Product Name</th>
                                <th>Original Price</th>
                                <th>Current Offer</th>
                                <th>Final Price</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($products as $prod): 
                                $finalPrice = $prod['price'];
                                if ($prod['offerPercent'] > 0) {
                                    $finalPrice = $prod['price'] - ($prod['price'] * $prod['offerPercent'] / 100);
                                }
                            ?>
                                <tr>
                                    <td><?php echo $prod['productId']; ?></td>
                                    <td><?php echo htmlspecialchars($prod['productName']); ?></td>
                                    <td>$<?php echo number_format($prod['price'], 2); ?></td>
                                    <td>
                                        <?php if ($prod['offerPercent'] > 0): ?>
                                            <span class="offer-badge"><?php echo $prod['offerPercent']; ?>% OFF</span>
                                        <?php else: ?>
                                            <span style="color: #999;">No Offer</span>
                                        <?php endif; ?>
                                    </td>
                                    <td style="font-weight: 600; color: #2ecc71;">$<?php echo number_format($finalPrice, 2); ?></td>
                                    <td>
                                        <div class="action-btns">
                                            <button type="button" class="btn btn-warning btn-sm" onclick="openOfferModal(<?php echo $prod['productId']; ?>, '<?php echo htmlspecialchars($prod['productName'], ENT_QUOTES); ?>', <?php echo $prod['offerPercent']; ?>)">
                                                <?php echo ($prod['offerPercent'] > 0) ? 'Edit Offer' : 'Add Offer'; ?>
                                            </button>
                                            <?php if ($prod['offerPercent'] > 0): ?>
                                                <form action="../../controllers/offerControl.php" method="POST" style="display: inline;">
                                                    <input type="hidden" name="action" value="remove">
                                                    <input type="hidden" name="productId" value="<?php echo $prod['productId']; ?>">
                                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Remove offer from this product?');">Remove</button>
                                                </form>
                                            <?php endif; ?>
                                            <button type="button" class="btn btn-info btn-sm" onclick="openPriceModal(<?php echo $prod['productId']; ?>, '<?php echo htmlspecialchars($prod['productName'], ENT_QUOTES); ?>', <?php echo $prod['price']; ?>)">Change Price</button>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
        
        <!-- Offer Modal -->
        <div id="offerModal" style="display: none; position: fixed; top: 0; left:  0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 2000; justify-content: center; align-items: center;">
            <div style="background: white; padding: 30px; border-radius: 10px; width: 100%; max-width: 400px;">
                <h3 style="margin-bottom: 20px;">Set Product Offer</h3>
                <p id="offerProductName" style="color: #666; margin-bottom: 15px;"></p>
                <form action="../../controllers/offerControl.php" method="POST">
                    <input type="hidden" name="action" value="add">
                    <input type="hidden" name="productId" id="offerProductId">
                    
                    <div class="form-group">
                        <label for="offerPercent">Discount Percentage (%)</label>
                        <input type="number" id="offerPercent" name="offerPercent" min="0" max="100" step="0.01" required>
                    </div>
                    
                    <div style="display: flex; gap: 10px;">
                        <button type="submit" class="btn btn-primary">Save Offer</button>
                        <button type="button" class="btn btn-secondary" onclick="closeOfferModal()">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
        
        <!-- Price Modal -->
        <div id="priceModal" style="display: none; position:  fixed; top: 0; left: 0; width: 100%; height: 100%; background:  rgba(0,0,0,0.5); z-index: 2000; justify-content:  center; align-items: center;">
            <div style="background:  white; padding: 30px; border-radius: 10px; width: 100%; max-width: 400px;">
                <h3 style="margin-bottom: 20px;">Change Product Price</h3>
                <p id="priceProductName" style="color: #666; margin-bottom: 15px;"></p>
                <form action="../../controllers/priceControl.php" method="POST">
                    <input type="hidden" name="productId" id="priceProductId">
                    
                    <div class="form-group">
                        <label for="newPrice">New Price ($)</label>
                        <input type="number" id="newPrice" name="price" min="0.01" step="0.01" required>
                    </div>
                    
                    <div style="display: flex; gap:  10px;">
                        <button type="submit" class="btn btn-primary">Update Price</button>
                        <button type="button" class="btn btn-secondary" onclick="closePriceModal()">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <script>
        function openOfferModal(productId, productName, currentOffer) {
            document.getElementById('offerProductId').value = productId;
            document.getElementById('offerProductName').textContent = 'Product: ' + productName;
            document.getElementById('offerPercent').value = currentOffer;
            document.getElementById('offerModal').style.display = 'flex';
        }
        
        function closeOfferModal() {
            document.getElementById('offerModal').style.display = 'none';
        }
        
        function openPriceModal(productId, productName, currentPrice) {
            document.getElementById('priceProductId').value = productId;
            document.getElementById('priceProductName').textContent = 'Product: ' + productName;
            document.getElementById('newPrice').value = currentPrice;
            document. getElementById('priceModal').style.display = 'flex';
        }
        
        function closePriceModal() {
            document.getElementById('priceModal').style.display = 'none';
        }
    </script>
</body>
</html>