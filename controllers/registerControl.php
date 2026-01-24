<?php
session_start();
require_once("../models/userModel.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = isset($_POST["email"]) ? trim($_POST["email"]) : "";
    $password = isset($_POST["password"]) ? $_POST["password"] : "";
    $confirmPassword = isset($_POST["confirmPassword"]) ? $_POST["confirmPassword"] : "";
    $firstName = isset($_POST["firstName"]) ? trim($_POST["firstName"]) : "";
    $lastName = isset($_POST["lastName"]) ? trim($_POST["lastName"]) : "";
    $phone = isset($_POST["phone"]) ? trim($_POST["phone"]) : "";
    $address = isset($_POST["address"]) ? trim($_POST["address"]) : "";
    $role = isset($_POST["role"]) ? intval($_POST["role"]) : 3;
    
    $errors = [];
    
    if (empty($email)) {
        $errors[] = "emailErr=" .urlencode("Email is required");
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "emailErr=" .urlencode("Invalid email format");
    } elseif (emailExists($email)) {
        $errors[] = "emailErr=" .urlencode("Email already registered");
    }
    
    if (empty($password)) {
        $errors[] = "passErr=" . urlencode("Password is required");
    } elseif (strlen($password) < 6) {
        $errors[] = "passErr=" . urlencode("Password must be at least 6 characters");
    }
    
    if ($password !== $confirmPassword) {
        $errors[] = "confirmPassErr=" . urlencode("Passwords do not match");
    }
    
    if (empty($firstName)) {
        $errors[] = "firstNameErr=" . urlencode("First name is required");
    }
    
    if (empty($lastName)) {
        $errors[] = "lastNameErr=" . urlencode("Last name is required");
    }
    
    if (! empty($errors)) {
        header("Location: ../views/register.php?" . implode("&", $errors));
        exit();
    }
    
    if ($role != 2 && $role != 3) {
        $role = 3;
    }
    
    $result = registerUser($email, $password, $firstName, $lastName, $phone, $address, $role);
    
    if ($result) {
        if ($role == 2) {
            header("Location: ../views/login.php?success=".urlencode("Registration successful!  Please wait for admin approval."));
        } else {
            header("Location: ../views/login.php?success=".urlencode("Registration successful! You can now login."));
        }
    } else {
        header("Location: ../views/register.php? genErr=".urlencode("Registration failed. Please try again."));
    }
}
?>