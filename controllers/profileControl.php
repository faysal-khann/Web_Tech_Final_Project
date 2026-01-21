<?php
session_start();
require_once("../models/userModel.php");

if (!isset($_SESSION['userId'])) {
    header("Location: ../views/login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $action = isset($_POST["action"]) ? $_POST["action"] : "";
    $userId = $_SESSION['userId'];
    $role = $_SESSION['role'];
    
    $redirect = "";
    switch ($role) {
        case 1: $redirect = "../views/admin_views/profile.php"; break;
        case 2: $redirect = "../views/employee_views/profile.php"; break;
        case 3: $redirect = "../views/customer_views/profile.php"; break;
    }
    
    if ($action == "update") {
        $firstName = isset($_POST["firstName"]) ? trim($_POST["firstName"]) : "";
        $lastName = isset($_POST["lastName"]) ? trim($_POST["lastName"]) : "";
        $phone = isset($_POST["phone"]) ? trim($_POST["phone"]) : "";
        $address = isset($_POST["address"]) ? trim($_POST["address"]) : "";
        
        $errors = [];
        
        if (empty($firstName)) {
            $errors[] = "firstNameErr=" . urlencode("First name is required");
        }
        
        if (empty($lastName)) {
            $errors[] = "lastNameErr=" . urlencode("Last name is required");
        }
        
        if (! empty($errors)) {
            header("Location: " . $redirect . "?" . implode("&", $errors));
            exit();
        }
        
        $result = updateUserProfile($userId, $firstName, $lastName, $phone, $address);
        
        if ($result) {
            $_SESSION['userName'] = $firstName . ' ' .  $lastName;
            header("Location: " . $redirect .  "? success=" . urlencode("Profile updated successfully"));
        } else {
            header("Location: " . $redirect .  "?genErr=" . urlencode("Failed to update profile"));
        }
    } elseif ($action == "delete") {
        $result = deleteUserProfile($userId);
        
        if ($result) {
            session_destroy();
            header("Location: ../views/login.php?success=" . urlencode("Account deleted successfully"));
        } else {
            header("Location: " . $redirect . "?genErr=" . urlencode("Failed to delete account"));
        }
    }
}
?>