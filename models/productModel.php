<?php
require_once("dbConnect.php");

// Get all products
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

// Get product by ID
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

// Add product
function addProduct($categoryId, $productName, $description, $specifications, $price, $quantity)
{
    $conn = dbConnect();
    $productName = mysqli_real_escape_string($conn, $productName);
    $description = mysqli_real_escape_string($conn, $description);
    $specifications = mysqli_real_escape_string($conn, $specifications);
    
    $query = "INSERT INTO products (categoryId, productName, description, specifications, price, quantity) 
              VALUES ($categoryId, '$productName', '$description', '$specifications', $price, $quantity)";
    mysqli_query($conn, $query);
    return mysqli_affected_rows($conn) > 0;
}

// Update product
function updateProduct($productId, $categoryId, $productName, $description, $specifications, $price)
{
    $conn = dbConnect();
    $productName = mysqli_real_escape_string($conn, $productName);
    $description = mysqli_real_escape_string($conn, $description);
    $specifications = mysqli_real_escape_string($conn, $specifications);
    
    $query = "UPDATE products SET categoryId=$categoryId, productName='$productName', 
              description='$description', specifications='$specifications', price=$price 
              WHERE productId=$productId";
    mysqli_query($conn, $query);
    return mysqli_affected_rows($conn) >= 0;
}

// Delete product
function deleteProduct($productId)
{
    $conn = dbConnect();
    $query = "UPDATE products SET status='inactive' WHERE productId=$productId";
    mysqli_query($conn, $query);
    return mysqli_affected_rows($conn) > 0;
}

// Update product price
function updateProductPrice($productId, $price)
{
    $conn = dbConnect();
    $query = "UPDATE products SET price=$price WHERE productId=$productId";
    mysqli_query($conn, $query);
    return mysqli_affected_rows($conn) >= 0;
}

// Update product offer
function updateProductOffer($productId, $offerPercent)
{
    $conn = dbConnect();
    $query = "UPDATE products SET offerPercent=$offerPercent WHERE productId=$productId";
    mysqli_query($conn, $query);
    return mysqli_affected_rows($conn) >= 0;
}

// Search products
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

// Get products by category
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