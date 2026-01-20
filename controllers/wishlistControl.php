<?php
session_start();
require_once("../models/wishlistModel.php");

if (!isset($_SESSION['userId']) || $_SESSION['role'] != 3) {
    header("Location: ../views/login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $action = isset($_POST["action"]) ? $_POST["action"] : "";
    $customerId = $_SESSION['userId'];
    $productId = isset($_POST["productId"]) ? intval($_POST["productId"]) : 0;
    
    if ($productId == 0) {
        header("Location: ../views/customer_views/browseProducts.php?genErr=" . urlencode("Invalid product"));
        exit();
    }
    
    if ($action == "add") {
        $result = addToWishlist($customerId, $productId); //WishList Model
        
        if ($result) {
            header("Location:  ../views/customer_views/browseProducts.php?success=" .  urlencode("Added to wishlist"));
        } else {
            header("Location: ../views/customer_views/browseProducts.php? genErr=" . urlencode("Failed to add to wishlist"));
        }
    } elseif ($action == "remove") {
        $result = removeFromWishlist($customerId, $productId); //WishList Model
        
        if ($result) {
            header("Location:  ../views/customer_views/wishlist.php?success=" . urlencode("Removed from wishlist"));
        } else {
            header("Location: ../views/customer_views/wishlist.php?genErr=" . urlencode("Failed to remove from wishlist"));
        }
    }
}
?>