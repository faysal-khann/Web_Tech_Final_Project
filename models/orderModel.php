<?php
require_once("dbConnect.php");

// Create order
function createOrder($customerId, $productId, $quantity, $unitPrice)
{
    $conn = dbConnect();
    $totalPrice = $quantity * $unitPrice;
    
    // Check stock availability
    $checkQuery = "SELECT quantity FROM products WHERE productId=$productId";
    $result = mysqli_query($conn, $checkQuery);
    $product = mysqli_fetch_assoc($result);
    
    if ($product['quantity'] < $quantity) {
        return false;
    }
    
    // Create order
    $query = "INSERT INTO orders (customerId, productId, quantity, unitPrice, totalPrice) 
              VALUES ($customerId, $productId, $quantity, $unitPrice, $totalPrice)";
    mysqli_query($conn, $query);
    
    // Reduce stock
    $updateStock = "UPDATE products SET quantity = quantity - $quantity WHERE productId=$productId";
    mysqli_query($conn, $updateStock);
    
    return mysqli_affected_rows($conn) > 0;
}

// Get orders by customer
function getOrdersByCustomer($customerId)
{
    $conn = dbConnect();
    $query = "SELECT o.*, p.productName, p.image 
              FROM orders o 
              JOIN products p ON o.productId = p.productId 
              WHERE o.customerId=$customerId 
              ORDER BY o. created_at DESC";
    $data = mysqli_query($conn, $query);
    
    $orders = [];
    while ($row = mysqli_fetch_assoc($data)) {
        $orders[] = $row;
    }
    return $orders;
}

// Get all orders
function getAllOrders()
{
    $conn = dbConnect();
    $query = "SELECT o.*, p.productName, u.firstName, u.lastName 
              FROM orders o 
              JOIN products p ON o.productId = p.productId 
              JOIN users u ON o.customerId = u.userId 
              ORDER BY o.created_at DESC";
    $data = mysqli_query($conn, $query);
    
    $orders = [];
    while ($row = mysqli_fetch_assoc($data)) {
        $orders[] = $row;
    }
    return $orders;
}


?>