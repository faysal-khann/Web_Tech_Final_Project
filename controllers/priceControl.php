<?php
session_start();
require_once("../models/productModel.php");

if (!isset($_SESSION['userId']) || $_SESSION['role'] != 2) {
    header("Location: ../views/login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $productId = isset($_POST["productId"]) ? intval($_POST["productId"]) : 0;
    $price = isset($_POST["price"]) ? floatval($_POST["price"]) : 0;
    
    if ($productId == 0 || $price <= 0) {
        header("Location: ../views/employee_views/manageOffers.php?genErr=" .  urlencode("Invalid product or price"));
        exit();
    }
    
    $result = updateProductPrice($productId, $price);
    
    if ($result) {
        header("Location: ../views/employee_views/manageOffers.php?success=" .  urlencode("Price updated successfully"));
    } else {
        header("Location: ../views/employee_views/manageOffers.php?genErr=" . urlencode("Failed to update price"));
    }
}
?>