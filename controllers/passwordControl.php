<?php
session_start();
require_once("../models/userModel.php");

if (!isset($_SESSION['userId'])) {
    header("Location: ../views/login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $userId = $_SESSION['userId'];
    $currentPassword = isset($_POST["currentPassword"]) ? $_POST["currentPassword"] : "";
    $newPassword = isset($_POST["newPassword"]) ? $_POST["newPassword"] : "";
    $confirmPassword = isset($_POST["confirmPassword"]) ? $_POST["confirmPassword"] : "";
    
    $role = $_SESSION['role'];
    $redirect = "";
    switch ($role) {
        case 1: $redirect = "../views/admin_views/changePassword.php"; break;
        case 2: $redirect = "../views/employee_views/changePassword.php"; break;
        case 3: $redirect = "../views/customer_views/changePassword.php"; break;
    }
    
    $errors = [];
    
    if (empty($currentPassword)) 
    {
        $errors[] = "currentPassErr=" . urlencode("Current password is required");
    } 
    elseif (! verifyPassword($userId, $currentPassword)) //User Model
    {
        $errors[] = "currentPassErr=" . urlencode("Current password is incorrect");
    }
    
    if (empty($newPassword)) 
    {
        $errors[] = "newPassErr=" . urlencode("New password is required");
    } 
    elseif (strlen($newPassword) < 6) 
    {
        $errors[] = "newPassErr=" . urlencode("Password must be at least 6 characters");
    }
    
    if ($newPassword !== $confirmPassword) 
    {
        $errors[] = "confirmPassErr=" . urlencode("Passwords do not match");
    }
    
    if (!empty($errors)) 
    {
        header("Location: " . $redirect . "?" . implode("&", $errors));
        exit();
    }
    
    $result = changePassword($userId, $newPassword); //User Model
    
    if ($result)
     {
        header("Location: " . $redirect .  "?success=" . urlencode("Password changed successfully"));
    } else 
    {
        header("Location: " . $redirect . "?genErr=" .  urlencode("Failed to change password"));
    }
}
?>