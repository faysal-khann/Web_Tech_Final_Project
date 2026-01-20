<?php
require_once("dbConnect.php");

function getAllProducts()
{
    $conn = dbConnect();
    $query = "SELECT p.*, c.categoryName FROM products p 
              JOIN categories c ON p. categoryId = c.categoryId 
              WHERE p.status='active' ORDER BY p.productName";
    $data = mysqli_query($conn, $query);
    
    $products = [];
    while ($row = mysqli_fetch_assoc($data)) {
        $products[] = $row;
    }
    return $products;
}



function searchProducts($searchTerm)
{
    $conn = dbConnect();
    $searchTerm = mysqli_real_escape_string($conn, $searchTerm);
    
    $query = "SELECT p.*, c.categoryName FROM products p 
              JOIN categories c ON p.categoryId = c.categoryId 
              WHERE p.status='active' AND (p.productName LIKE '%$searchTerm%' OR c.categoryName LIKE '%$searchTerm%')
              ORDER BY p.productName";
    $data = mysqli_query($conn, $query);
    
    $products = [];
    while ($row = mysqli_fetch_assoc($data)) {
        $products[] = $row;
    }
    return $products;
}

function getProductById($productId)
{
    $conn = dbConnect();
    $query = "SELECT p.*, c. categoryName FROM products p 
              JOIN categories c ON p.categoryId = c.categoryId 
              WHERE p.productId=$productId";
    $data = mysqli_query($conn, $query);
    
    if (mysqli_num_rows($data) > 0) {
        return mysqli_fetch_assoc($data);
    }
    return null;
}


function getProductsByCategory($categoryId)
{
    $conn = dbConnect();
    $query = "SELECT p.*, c.categoryName FROM products p 
              JOIN categories c ON p.categoryId = c.categoryId 
              WHERE p.status='active' AND p.categoryId=$categoryId ORDER BY p.productName";
    $data = mysqli_query($conn, $query);
    
    $products = [];
    while ($row = mysqli_fetch_assoc($data)) {
        $products[] = $row;
    }
    return $products;
}
?>