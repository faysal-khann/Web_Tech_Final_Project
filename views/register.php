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
    <link rel="stylesheet" href="css/styles.css">
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
                        <input type="radio" name="role" value="3">
                        <span>👤 Customer</span>
                    </label>
                    <label class="role-option" id="employeeOption">
                        <input type="radio" name="role" value="2">
                        <span>💼 Employee</span>
                    </label>
                </div>
            </div>
            
            <div class="form-group">
                <label for="email">Email Address *</label>
                <input type="email" id="email" name="email" placeholder="Enter your email">
                <span class="error-message" id="emailError"></span>
            </div>
            
            <div class="form-group">
                <label for="firstName">First Name *</label>
                <input type="text" id="firstName" name="firstName" placeholder="Enter first name">
                <span class="error-message" id="firstNameError"></span>
            </div>
            
            <div class="form-group">
                <label for="lastName">Last Name *</label>
                <input type="text" id="lastName" name="lastName" placeholder="Enter last name">
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
                <span class="error-message" id="passwordError"></span>
            </div>
            
            <div class="form-group">
                <label for="confirmPassword">Confirm Password *</label>
                <input type="password" id="confirmPassword" name="confirmPassword" placeholder="Confirm your password">
                <span class="error-message" id="confirmPasswordError"></span>
            </div>
            
            <button type="submit" class="btn btn-primary">Register</button>
        </form>
        
        <div class="links">
            <p>Already have an account? <a href="login.php">Login here</a></p>
        </div>
    </div>
    
     <script>
    const emailInput = document.getElementById('email');
    const emailError = document.getElementById('emailError');

    let emailTimer = null;

    emailInput.addEventListener('keyup', function () {
    clearTimeout(emailTimer);

    emailTimer = setTimeout(() => {
        const email = emailInput.value.trim();

        if (!email) {
            emailError.textContent = '';
            return;
        }

        fetch(`../controllers/checkEmail.php?email=${encodeURIComponent(email)}`)
            .then(res => res.json())
            .then(data => {
                if (data.status === "exists") {
                    emailError.textContent = data.message;
                    emailError.style.color = "red";
                } else if (data.status === "available") {
                    emailError.textContent = data.message;
                    emailError.style.color = "green";
                } else {
                    emailError.textContent = data.message;
                    emailError.style.color = "red";
                }
            })
            .catch(() => {
                emailError.textContent = "Error checking email";
                emailError.style.color = "red";
            });

    }, 50); // delay to prevent too many requests
});
</script>

</body>
</html>
