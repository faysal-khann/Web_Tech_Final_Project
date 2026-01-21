<?php
require_once("dbConnect.php");

function getAllCategories()
{
    $conn = dbConnect();
    $query = "SELECT * FROM categories WHERE status='active' ORDER BY categoryName";
    $data = mysqli_query($conn, $query);
    
    $categories = [];
    while ($row = mysqli_fetch_assoc($data)) {
        $categories[] = $row;
    }
    return $categories;
}

function getCategoryById($categoryId)
{
    $conn = dbConnect();
    $query = "SELECT * FROM categories WHERE categoryId=$categoryId";
    $data = mysqli_query($conn, $query);
    
    if (mysqli_num_rows($data) > 0) {
        return mysqli_fetch_assoc($data);
    }
    return null;
}

function addCategory($categoryName, $description)
{
    $conn = dbConnect();
    $categoryName = mysqli_real_escape_string($conn, $categoryName);
    $description = mysqli_real_escape_string($conn, $description);
    
    $query = "INSERT INTO categories (categoryName, description) VALUES ('$categoryName', '$description')";
    mysqli_query($conn, $query);
    return mysqli_affected_rows($conn) > 0;
}

function updateCategory($categoryId, $categoryName, $description)
{
    $conn = dbConnect();
    $categoryName = mysqli_real_escape_string($conn, $categoryName);
    $description = mysqli_real_escape_string($conn, $description);
    
    $query = "UPDATE categories SET categoryName='$categoryName', description='$description' WHERE categoryId=$categoryId";
    mysqli_query($conn, $query);
    return mysqli_affected_rows($conn) >= 0;
}

function deleteCategory($categoryId)
{
    $conn = dbConnect();
    $query = "UPDATE categories SET status='inactive' WHERE categoryId=$categoryId";
    mysqli_query($conn, $query);
    return mysqli_affected_rows($conn) > 0;
}

function categoryExists($categoryName)
{
    $conn = dbConnect();
    $categoryName = mysqli_real_escape_string($conn, $categoryName);
    $query = "SELECT categoryId FROM categories WHERE categoryName='$categoryName' AND status='active'";
    $data = mysqli_query($conn, $query);
    return mysqli_num_rows($data) > 0;
}
?>