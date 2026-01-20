<?php
session_start();
require_once("../models/orderModel.php");
require_once("../models/productModel.php");

if (!isset($_SESSION['userId']) || $_SESSION['role'] != 3) {
    header("Location:  ../views/login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $customerId = $_SESSION['userId'];
    $productId = isset($_POST["productId"]) ? intval($_POST["productId"]) : 0;
    $quantity = isset($_POST["quantity"]) ? intval($_POST["quantity"]) : 1;
    
    if ($productId == 0 || $quantity <= 0) {
        header("Location: ../views/customer_views/browseProducts.php?genErr=" . urlencode("Invalid product or quantity"));
        exit();
    }
    
    $product = getProductById($productId); //Product model
    
    if (!$product) {
        header("Location:  ../views/customer_views/browseProducts.php?genErr=" . urlencode("Product not found"));
        exit();
    }
    
    $unitPrice = $product['price'];
    if ($product['offerPercent'] > 0) {
        $unitPrice = $product['price'] - ($product['price'] * $product['offerPercent'] / 100);
    }
    
    $result = createOrder($customerId, $productId, $quantity, $unitPrice); //Order model
    
    if ($result) {
        header("Location: ../views/customer_views/orderHistory.php?success=" . urlencode("Order placed successfully"));
    } else {
        header("Location: ../views/customer_views/browseProducts.php?genErr=" . urlencode("Insufficient stock or order failed"));
    }
}
?>