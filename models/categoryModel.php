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

?>