<?php
require_once("dbConnect.php");

function addStock($productId, $employeeId, $quantity, $notes)
{
    $conn = dbConnect();
    $notes = mysqli_real_escape_string($conn, $notes);
    
    $query1 = "UPDATE products SET quantity = quantity + $quantity WHERE productId=$productId";
    mysqli_query($conn, $query1);
    
    $query2 = "INSERT INTO stock_logs (productId, employeeId, activity, quantity, notes) 
               VALUES ($productId, $employeeId, 'stock_in', $quantity, '$notes')";
    mysqli_query($conn, $query2);
    
    return mysqli_affected_rows($conn) > 0;
}

function removeStock($productId, $employeeId, $quantity, $notes)
{
    $conn = dbConnect();
    $notes = mysqli_real_escape_string($conn, $notes);
    
    $checkQuery = "SELECT quantity FROM products WHERE productId=$productId";
    $result = mysqli_query($conn, $checkQuery);
    $product = mysqli_fetch_assoc($result);
    
    if ($product['quantity'] < $quantity) {
        return false;
    }
    
    $query1 = "UPDATE products SET quantity = quantity - $quantity WHERE productId=$productId";
    mysqli_query($conn, $query1);
    
    $query2 = "INSERT INTO stock_logs (productId, employeeId, activity, quantity, notes) 
               VALUES ($productId, $employeeId, 'stock_out', $quantity, '$notes')";
    mysqli_query($conn, $query2);
    
    return mysqli_affected_rows($conn) > 0;
}

function getAllStockLogs()
{
    $conn = dbConnect();
    $query = "SELECT sl.*, p.productName, u.firstName, u.lastName 
              FROM stock_logs sl 
              JOIN products p ON sl.productId = p.productId 
              JOIN users u ON sl.employeeId = u.userId 
              ORDER BY sl.created_at DESC";
    $data = mysqli_query($conn, $query);
    
    $logs = [];
    while ($row = mysqli_fetch_assoc($data)) {
        $logs[] = $row;
    }
    return $logs;
}

function getStockLogsByEmployee($employeeId)
{
    $conn = dbConnect();
    $query = "SELECT sl.*, p. productName 
              FROM stock_logs sl 
              JOIN products p ON sl. productId = p.productId 
              WHERE sl.employeeId=$employeeId 
              ORDER BY sl.created_at DESC";
    $data = mysqli_query($conn, $query);
    
    $logs = [];
    while ($row = mysqli_fetch_assoc($data)) {
        $logs[] = $row;
    }
    return $logs;
}
?>