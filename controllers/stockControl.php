<?php
session_start();
require_once("../models/stockModel.php");

if (!isset($_SESSION['userId']) || $_SESSION['role'] != 2) {
    header("Location: ../views/login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $action = isset($_POST["action"]) ? $_POST["action"] : "";
    $productId = isset($_POST["productId"]) ? intval($_POST["productId"]) : 0;
    $quantity = isset($_POST["quantity"]) ? intval($_POST["quantity"]) : 0;
    $notes = isset($_POST["notes"]) ? trim($_POST["notes"]) : "";
    $employeeId = $_SESSION['userId'];
    
    if ($productId == 0 || $quantity <= 0) {
        header("Location: ../views/employee_views/manageStock.php?genErr=" . urlencode("Invalid product or quantity"));
        exit();
    }
    
    if ($action == "stock_in") {
        $result = addStock($productId, $employeeId, $quantity, $notes);
        
        if ($result) {
            header("Location:  ../views/employee_views/manageStock.php?success=" .  urlencode("Stock added successfully"));
        } else {
            header("Location: ../views/employee_views/manageStock.php? genErr=" . urlencode("Failed to add stock"));
        }
    } elseif ($action == "stock_out") {
        $result = removeStock($productId, $employeeId, $quantity, $notes);
        
        if ($result) {
            header("Location: ../views/employee_views/manageStock.php?success=" . urlencode("Stock removed successfully"));
        } else {
            header("Location: ../views/employee_views/manageStock.php?genErr=" .  urlencode("Insufficient stock or failed to remove"));
        }
    }
}
?>