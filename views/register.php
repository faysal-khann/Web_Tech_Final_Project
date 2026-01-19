<?php
session_start();
if (isset($_SESSION['userId'])) {
    switch ($_SESSION['role']) {
        case 1: header("Location: admin_views/home.php"); break;
        case 2: header("Location: employee_views/home.php"); break;
        case 3: header("Location: customer_views/home.php"); break;
    }
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - GadgetGrid</title>
   
</head>
<body>
    <div class="container" style="max-width: 500px;">
        <div class="logo">
            <h1>🔌 GadgetGrid</h1>
            <p>Create your account</p>
        </div>
        
        <?php if (isset($_GET["genErr"])): ?>
            <div class="general-error"><?php echo htmlspecialchars($_GET["genErr"]); ?></div>
        <?php endif; ?>
        
        <form action="../controllers/registerControl.php" method="POST" id="registerForm">
            <div class="form-group">
                <label>Register as:</label>
                <div class="role-select">
                    <label class="role-option selected" id="customerOption">
                        <input type="radio" name="role" value="3" checked>
                        <span> Customer</span>
                    </label>
                    <label class="role-option" id="employeeOption">
                        <input type="radio" name="role" value="2">
                        <span> Employee</span>
                    </label>
                </div>
            </div>
            
            <div class="form-group">
                <label for="email">Email Address *</label>
                <input type="email" id="email" name="email" placeholder="Enter your email">
                <?php if (isset($_GET["emailErr"])): ?>
                    <span class="error-message"><?php echo htmlspecialchars($_GET["emailErr"]); ?></span>
                <?php endif; ?>
                <span class="error-message" id="emailError"></span>
            </div>
            
            <div class="form-group">
                <label for="firstName">First Name *</label>
                <input type="text" id="firstName" name="firstName" placeholder="Enter first name">
                <?php if (isset($_GET["firstNameErr"])): ?>
                    <span class="error-message"><?php echo htmlspecialchars($_GET["firstNameErr"]); ?></span>
                <?php endif; ?>
                <span class="error-message" id="firstNameError"></span>
            </div>
            
            <div class="form-group">
                <label for="lastName">Last Name *</label>
                <input type="text" id="lastName" name="lastName" placeholder="Enter last name">
                <?php if (isset($_GET["lastNameErr"])): ?>
                    <span class="error-message"><?php echo htmlspecialchars($_GET["lastNameErr"]); ?></span>
                <?php endif; ?>
                <span class="error-message" id="lastNameError"></span>
            </div>
            
            <div class="form-group">
                <label for="phone">Phone Number</label>
                <input type="text" id="phone" name="phone" placeholder="Enter phone number">
            </div>
            
            <div class="form-group">
                <label for="address">Address</label>
                <textarea id="address" name="address" placeholder="Enter your address" rows="2"></textarea>
            </div>
            
            <div class="form-group">
                <label for="password">Password *</label>
                <input type="password" id="password" name="password" placeholder="Enter password (min 6 chars)">
                <?php if (isset($_GET["passErr"])): ?>
                    <span class="error-message"><?php echo htmlspecialchars($_GET["passErr"]); ?></span>
                <?php endif; ?>
                <span class="error-message" id="passwordError"></span>
            </div>
            
            <div class="form-group">
                <label for="confirmPassword">Confirm Password *</label>
                <input type="password" id="confirmPassword" name="confirmPassword" placeholder="Confirm your password">
                <?php if (isset($_GET["confirmPassErr"])): ?>
                    <span class="error-message"><?php echo htmlspecialchars($_GET["confirmPassErr"]); ?></span>
                <?php endif; ?>
                <span class="error-message" id="confirmPasswordError"></span>
            </div>
            
            <button type="submit" class="btn btn-primary">Register</button>
        </form>
        
        <div class="links">
            <p>Already have an account? <a href="login.php">Login here</a></p>
        </div>
    </div>
    
    <script>
        // Role selection styling
        const roleOptions = document.querySelectorAll('. role-option');
        roleOptions.forEach(option => {
            option.addEventListener('click', function() {
                roleOptions.forEach(opt => opt. classList.remove('selected'));
                this.classList.add('selected');
            });
        });
        
        // Form validation
        document.getElementById('registerForm').addEventListener('submit', function(e) {
            let isValid = true;
            
            // Clear previous errors
            document.querySelectorAll('.error-message[id]').forEach(el => el.textContent = '');
            
            const email = document.getElementById('email').value.trim();
            const firstName = document. getElementById('firstName').value.trim();
            const lastName = document.getElementById('lastName').value.trim();
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('confirmPassword').value;
            
            if (!email) {
                document. getElementById('emailError').textContent = 'Email is required';
                isValid = false;
            } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/. test(email)) {
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
                document.getElementById('passwordError').textContent = 'Password is required';
                isValid = false;
            } else if (password.length < 6) {
                document.getElementById('passwordError').textContent = 'Password must be at least 6 characters';
                isValid = false;
            }
            
            if (password !== confirmPassword) {
                document.getElementById('confirmPasswordError').textContent = 'Passwords do not match';
                isValid = false;
            }
            
            if (!isValid) {
                e.preventDefault();
            }
        });
    </script>
</body>
</html>

