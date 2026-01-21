<?php
session_start();
require_once("../models/userModel.php");

if (!isset($_SESSION['userId']) || $_SESSION['role'] != 2) {
    header("Location:  ../views/login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $action = isset($_POST["action"]) ? $_POST["action"] : "";
    
    if ($action == "add") {
        $email = isset($_POST["email"]) ? trim($_POST["email"]) : "";
        $password = isset($_POST["password"]) ? $_POST["password"] : "";
        $firstName = isset($_POST["firstName"]) ? trim($_POST["firstName"]) : "";
        $lastName = isset($_POST["lastName"]) ? trim($_POST["lastName"]) : "";
        $phone = isset($_POST["phone"]) ? trim($_POST["phone"]) : "";
        $address = isset($_POST["address"]) ? trim($_POST["address"]) : "";
        
        $errors = [];
        
        if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "emailErr=" . urlencode("Valid email is required");
        } elseif (emailExists($email)) {
            $errors[] = "emailErr=" .  urlencode("Email already exists");
        }
        
        if (empty($password) || strlen($password) < 6) {
            $errors[] = "passErr=" . urlencode("Password must be at least 6 characters");
        }
        
        if (empty($firstName)) {
            $errors[] = "firstNameErr=" . urlencode("First name is required");
        }
        
        if (empty($lastName)) {
            $errors[] = "lastNameErr=" .  urlencode("Last name is required");
        }
        
        if (! empty($errors)) {
            header("Location: ../views/employee_views/addCustomer.php?" . implode("&", $errors));
            exit();
        }
        
        $result = addCustomer($email, $password, $firstName, $lastName, $phone, $address);
        
        if ($result) {
            header("Location: ../views/employee_views/manageCustomers.php?success=" . urlencode("Customer added successfully"));
        } else {
            header("Location:  ../views/employee_views/addCustomer.php?genErr=" . urlencode("Failed to add customer"));
        }
    } elseif ($action == "delete") {
        $customerId = isset($_POST["customerId"]) ? intval($_POST["customerId"]) : 0;
        
        $result = removeCustomer($customerId);
        
        if ($result) {
            header("Location: ../views/employee_views/manageCustomers.php?success=" . urlencode("Customer removed successfully"));
        } else {
            header("Location: ../views/employee_views/manageCustomers.php?genErr=" . urlencode("Failed to remove customer"));
        }
    }
}
?>