<?php
session_start();
require_once("../models/productModel.php");

if (!isset($_SESSION['userId']) || $_SESSION['role'] != 2) {
    header("Location: ../views/login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $action = isset($_POST["action"]) ? $_POST["action"] : "";
    $productId = isset($_POST["productId"]) ? intval($_POST["productId"]) : 0;
    
    if ($productId == 0) {
        header("Location: ../views/employee_views/manageOffers. php?genErr=" . urlencode("Invalid product"));
        exit();
    }
    
    if ($action == "add") {
        $offerPercent = isset($_POST["offerPercent"]) ? floatval($_POST["offerPercent"]) : 0;
        
        if ($offerPercent < 0 || $offerPercent > 100) {
            header("Location: ../views/employee_views/manageOffers. php?genErr=" . urlencode("Offer must be between 0 and 100%"));
            exit();
        }
        
        $result = updateProductOffer($productId, $offerPercent);
        
        if ($result) {
            header("Location: ../views/employee_views/manageOffers.php? success=" . urlencode("Offer added successfully"));
        } else {
            header("Location: ../views/employee_views/manageOffers.php?genErr=" . urlencode("Failed to add offer"));
        }
    } elseif ($action == "remove") {
        $result = updateProductOffer($productId, 0);
        
        if ($result) {
            header("Location: ../views/employee_views/manageOffers.php?success=" . urlencode("Offer removed successfully"));
        } else {
            header("Location: ../views/employee_views/manageOffers.php?genErr=" .  urlencode("Failed to remove offer"));
        }
    }
}
?>