<?php
require_once("dbConnect.php");

function addToWishlist($customerId, $productId)
{
    $conn = dbConnect();
    $query = "INSERT IGNORE INTO wishlist (customerId, productId) VALUES ($customerId, $productId)";
    mysqli_query($conn, $query);
    return mysqli_affected_rows($conn) >= 0;
}

function removeFromWishlist($customerId, $productId)
{
    $conn = dbConnect();
    $query = "DELETE FROM wishlist WHERE customerId=$customerId AND productId=$productId";
    mysqli_query($conn, $query);
    return mysqli_affected_rows($conn) > 0;
}

function getWishlistByCustomer($customerId)
{
    $conn = dbConnect();
    $query = "SELECT w.*, p.productName, p.price, p.offerPercent, p.quantity as stock, c.categoryName 
              FROM wishlist w 
              JOIN products p ON w.productId = p. productId 
              JOIN categories c ON p.categoryId = c. categoryId 
              WHERE w. customerId=$customerId AND p.status='active'
              ORDER BY w.created_at DESC";
    $data = mysqli_query($conn, $query);
    
    $wishlist = [];
    while ($row = mysqli_fetch_assoc($data)) {
        $wishlist[] = $row;
    }
    return $wishlist;
}

function isInWishlist($customerId, $productId)
{
    $conn = dbConnect();
    $query = "SELECT wishlistId FROM wishlist WHERE customerId=$customerId AND productId=$productId";
    $data = mysqli_query($conn, $query);
    return mysqli_num_rows($data) > 0;
}
?>