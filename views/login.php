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
    <title>Login - GadgetGrid</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <div class="container">
        <div class="logo">
            <h1>🔌 GadgetGrid</h1>
            <p>Tech Accessories Management System</p>
        </div>
        
        <?php if (isset($_GET["success"])): ?>
            <div class="success-message"><?php echo htmlspecialchars($_GET["success"]); ?></div>
        <?php endif; ?>
        
        <?php if (isset($_GET["genErr"])): ?>
            <div class="general-error"><?php echo htmlspecialchars($_GET["genErr"]); ?></div>
        <?php endif; ?>
        
        <form action="../controllers/authControl.php" method="POST" id="loginForm">
            <div class="form-group">
                <label for="email">Email Address</label>
                <input type="email" id="email" name="email" placeholder="Enter your email">
                <?php if (isset($_GET["emailErr"])): ?>
                    <span class="error-message"><?php echo htmlspecialchars($_GET["emailErr"]); ?></span>
                <?php endif; ?>
                <span class="error-message" id="emailError"></span>
            </div>
            
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Enter your password">
                <?php if (isset($_GET["passErr"])): ?>
                    <span class="error-message"><?php echo htmlspecialchars($_GET["passErr"]); ?></span>
                <?php endif; ?>
                <span class="error-message" id="passwordError"></span>
            </div>
            
            <button type="submit" class="btn btn-primary">Login</button>
        </form>
        
        <div class="links">
            <p>Don't have an account?  <a href="register.php">Register here</a></p>
        </div>
    </div>
    
<script>
    const loginEmail = document.getElementById('email');
    const loginEmailError = document.getElementById('emailError');

    let loginTimer = null;

    loginEmail.addEventListener('keyup', function () {
    clearTimeout(loginTimer);

    loginTimer = setTimeout(() => {
        const email = loginEmail.value.trim();

        if (!email) {
            loginEmailError.textContent = '';
            return;
        }

        fetch(`../controllers/checkLoginEmail.php?email=${encodeURIComponent(email)}`)
            .then(res => res.json())
            .then(data => {
                if (data.status === "exists") {
                    loginEmailError.textContent = data.message;
                    loginEmailError.style.color = "green";
                } else if (data.status === "not_found") {
                    loginEmailError.textContent = data.message;
                    loginEmailError.style.color = "red";
                } else {
                    loginEmailError.textContent = data.message;
                    loginEmailError.style.color = "red";
                }
            })
            .catch(() => {
                loginEmailError.textContent = "Server error";
                loginEmailError.style.color = "red";
            });

    }, 500);
});
</script>
</body>
</html>