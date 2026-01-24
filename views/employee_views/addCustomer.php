
<?php
session_start();
if (!isset($_SESSION['userId']) || $_SESSION['role'] != 2) {
    header("Location: ../login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Customer - GadgetGrid Employee</title>
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
            <h1>Add New Customer</h1>
            <div class="header-user">
                <span>Welcome, <?php echo htmlspecialchars($_SESSION['userName']); ?></span>
                <a href="../logout.php" class="btn-logout">Logout</a>
            </div>
        </div>
        
        <div class="content-box" style="max-width: 600px;">
            <?php if (isset($_GET["genErr"])): ?>
                <div class="general-error"><?php echo htmlspecialchars($_GET["genErr"]); ?></div>
            <?php endif; ?>
            
            <form action="../../controllers/customerControl.php" method="POST" id="customerForm">
                <input type="hidden" name="action" value="add">
                
                <div class="form-group">
                    <label for="email">Email Address *</label>
                    <input type="email" id="email" name="email" placeholder="customer@example.com">
                    <?php if (isset($_GET["emailErr"])): ?>
                        <span class="error-message"><?php echo htmlspecialchars($_GET["emailErr"]); ?></span>
                    <?php endif; ?>
                    <span class="error-message" id="emailError"></span>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="firstName">First Name *</label>
                        <input type="text" id="firstName" name="firstName" placeholder="First name">
                        <?php if (isset($_GET["firstNameErr"])): ?>
                            <span class="error-message"><?php echo htmlspecialchars($_GET["firstNameErr"]); ?></span>
                        <?php endif; ?>
                        <span class="error-message" id="firstNameError"></span>
                    </div>
                    
                    <div class="form-group">
                        <label for="lastName">Last Name *</label>
                        <input type="text" id="lastName" name="lastName" placeholder="Last name">
                        <?php if (isset($_GET["lastNameErr"])): ?>
                            <span class="error-message"><?php echo htmlspecialchars($_GET["lastNameErr"]); ?></span>
                        <?php endif; ?>
                        <span class="error-message" id="lastNameError"></span>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="password">Password *</label>
                    <input type="password" id="password" name="password" placeholder="Min 6 characters">
                    <?php if (isset($_GET["passErr"])): ?>
                        <span class="error-message"><?php echo htmlspecialchars($_GET["passErr"]); ?></span>
                    <?php endif; ?>
                    <span class="error-message" id="passError"></span>
                </div>
                
                <div class="form-group">
                    <label for="phone">Phone Number</label>
                    <input type="text" id="phone" name="phone" placeholder="Phone number">
                </div>
                
                <div class="form-group">
                    <label for="address">Address</label>
                    <textarea id="address" name="address" rows="3" placeholder="Customer address"></textarea>
                </div>
                
                <div style="display: flex; gap: 10px;">
                    <button type="submit" class="btn btn-primary">Add Customer</button>
                    <a href="manageCustomers.php" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
    
    <script>
        document.getElementById('customerForm').addEventListener('submit', function(e) {
            let isValid = true;
            document.querySelectorAll('.error-message[id]').forEach(el => el.textContent = '');
            
            const email = document.getElementById('email').value.trim();
            const firstName = document.getElementById('firstName').value.trim();
            const lastName = document.getElementById('lastName').value.trim();
            const password = document.getElementById('password').value;
            
            if (!email) {
                document.getElementById('emailError').textContent = 'Email is required';
                isValid = false;
            } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
                document.getElementById('emailError').textContent = 'Invalid email format';
                isValid = false;
            }
            
            if (!firstName) {
                document.getElementById('firstNameError').textContent = 'First name is required';
                isValid = false;
            }
            
            if (!lastName) {
                document.getElementById('lastNameError').textContent = 'Last name is required';
                isValid = false;
            }
            
            if (!password) {
                document.getElementById('passError').textContent = 'Password is required';
                isValid = false;
            } else if (password.length < 6) {
                document.getElementById('passError').textContent = 'Password must be at least 6 characters';
                isValid = false;
            }
            
            if (!isValid) e.preventDefault();
        });
    </script>
</body>
</html>
