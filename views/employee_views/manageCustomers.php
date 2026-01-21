<?php
session_start();
if (!isset($_SESSION['userId']) || $_SESSION['role'] != 2) {
    header("Location: ../login. php");
    exit();
}

require_once("../../models/userModel.php");
$customers = getAllCustomers();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Customers - GadgetGrid Employee</title>
    <link rel="stylesheet" href="css/employee_styles.css">
</head>
<body>
    <div class="sidebar">
        <div class="sidebar-header">
            <h2> GadgetGrid</h2>
            <p>Employee Panel</p>
        </div>
        <ul class="sidebar-menu">
            <li><a href="home.php"> Dashboard</a></li>
            <li><a href="manageCustomers.php" class="active">👥 Customers</a></li>
            <li><a href="manageProducts.php"> Products</a></li>
            <li><a href="manageStock.php"> Stock Management</a></li>
            <li><a href="manageOffers.php"> Offers</a></li>
            <li><a href="profile.php"> Profile</a></li>
            <li><a href="changePassword.php"> Change Password</a></li>
        </ul>
    </div>
    
    <div class="main-content">
        <div class="header">
            <h1>Manage Customers</h1>
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
            
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                <h2 style="margin: 0; border:  none; padding: 0;">Customer List</h2>
                <a href="addCustomer.php" class="btn btn-primary">+ Add New Customer</a>
            </div>
            
            <?php if (empty($customers)): ?>
                <p style="color: #666; padding: 20px 0;">No customers found.</p>
            <?php else: ?>
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Address</th>
                                <th>Joined On</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($customers as $cust): ?>
                                <tr>
                                    <td><?php echo $cust['userId']; ?></td>
                                    <td><?php echo htmlspecialchars($cust['firstName'] . ' ' . $cust['lastName']); ?></td>
                                    <td><?php echo htmlspecialchars($cust['email']); ?></td>
                                    <td><?php echo htmlspecialchars($cust['phone'] ?? 'N/A'); ?></td>
                                    <td><?php echo htmlspecialchars($cust['address'] ?? 'N/A'); ?></td>
                                    <td><?php echo date('M d, Y', strtotime($cust['created_at'])); ?></td>
                                    <td>
                                        <form action="../../controllers/customerControl.php" method="POST" style="display: inline;">
                                            <input type="hidden" name="action" value="delete">
                                            <input type="hidden" name="customerId" value="<?php echo $cust['userId']; ?>">
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to remove this customer?');">Remove</button>
                                        </form>
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