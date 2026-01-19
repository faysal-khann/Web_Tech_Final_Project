<?php
session_start();
require_once("../models/userModel.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = isset($_POST["email"]) ? trim($_POST["email"]) : "";
    $pass = isset($_POST["password"]) ? $_POST["password"] : "";
    
    $errors = [];
    
    if (empty($email)) {
        $errors[] = "emailErr=" . urlencode("Email is required");
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "emailErr=" . urlencode("Invalid email format");
    }
    
    if (empty($pass)) {
        $errors[] = "passErr=" . urlencode("Password is required");
    }
    
    if (! empty($errors)) {
        header("Location: ../views/login.php?" . implode("&", $errors));
        exit();
    }
    
    $user = authUser($email, $pass);
    
    if ($user) {
        if ($user['status'] == 'active') {
            $_SESSION['userId'] = $user['userId'];
            $_SESSION['role'] = $user['role'];
            $_SESSION['userName'] = $user['firstName'] .  ' ' . $user['lastName'];
            
            switch ($user['role']) {
                case 1:
                    header("Location:  ../views/admin_views/home.php");
                    break;
                case 2:
                    header("Location: ../views/employee_views/home.php");
                    break;
                case 3:
                    header("Location: ../views/customer_views/home.php");
                    break;
                default:
                    header("Location: ../views/login.php? genErr=" . urlencode("Invalid user role"));
            }
        } elseif ($user['status'] == 'pending') {
            header("Location:  ../views/login.php?genErr=" . urlencode("Your account is pending approval"));
        } elseif ($user['status'] == 'rejected') {
            header("Location:  ../views/login.php?genErr=" . urlencode("Your account has been rejected"));
        } else {
            header("Location:  ../views/login.php?genErr=" . urlencode("Your account is inactive"));
        }
    } else {
        header("Location: ../views/login.php?genErr=" . urlencode("Invalid email or password"));
    }
}
?>