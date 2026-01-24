<?php
session_start();
require_once("../models/productModel.php");

if (!isset($_SESSION['userId']) || $_SESSION['role'] != 2) {
    header("Location:  ../views/login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST")
 {
    $action = isset($_POST["action"]) ? $_POST["action"] : "";
    
    if ($action == "add") {
        $categoryId = isset($_POST["categoryId"]) ? intval($_POST["categoryId"]) : 0;
        $productName = isset($_POST["productName"]) ? trim($_POST["productName"]) : "";
        $description = isset($_POST["description"]) ? trim($_POST["description"]) : "";
        $specifications = isset($_POST["specifications"]) ? trim($_POST["specifications"]) : "";
        $price = isset($_POST["price"]) ? floatval($_POST["price"]) : 0;
        $quantity = isset($_POST["quantity"]) ? intval($_POST["quantity"]) : 0;

        // Handle the image upload
        $imagePath = "";
    if (isset($_FILES["productImage"]) && $_FILES["productImage"]["error"] == 0)
     {
    $uploadDir = "../uploads/products/";
    global $imagePath;
    $imageName = basename($_FILES["productImage"]["name"]);
    $imagePath = $imageName; // WE STORE ONLY THE FILENAME IN DB

    move_uploaded_file($_FILES["productImage"]["tmp_name"], $uploadDir . $imageName);
    }
            



        $errors = [];
        
        if ($categoryId == 0) {
            $errors[] = "categoryErr=" . urlencode("Please select a category");
        }
        if (empty($productName)) {
            $errors[] = "nameErr=" . urlencode("Product name is required");
        }
        if ($price <= 0) {
            $errors[] = "priceErr=" . urlencode("Price must be greater than 0");
        }

        if (!empty($errors)) {
            header("Location: ../views/employee_views/addProduct.php?" . implode("&", $errors));
            exit();
        }
        
        // Pass the image path to the addProduct function
        $result = addProduct($categoryId, $productName, $description, $specifications, $price, $quantity, $imagePath);
        
        if ($result) {
            header("Location: ../views/employee_views/manageProducts.php?success=" .  urlencode("Product added successfully"));
        } else {
            header("Location: ../views/employee_views/addProduct.php?genErr=" . urlencode("Failed to add product"));
        }
    }
    elseif ($action == "update") {
        $productId = isset($_POST["productId"]) ? intval($_POST["productId"]) : 0;
        $categoryId = isset($_POST["categoryId"]) ? intval($_POST["categoryId"]) : 0;
        $productName = isset($_POST["productName"]) ? trim($_POST["productName"]) : "";
        $description = isset($_POST["description"]) ? trim($_POST["description"]) : "";
        $specifications = isset($_POST["specifications"]) ? trim($_POST["specifications"]) : "";
        $price = isset($_POST["price"]) ? floatval($_POST["price"]) : 0;
        
        $result = updateProduct($productId, $categoryId, $productName, $description, $specifications, $price);
        
        if ($result) {
            header("Location: ../views/employee_views/manageProducts.php?success=" . urlencode("Product updated successfully"));
        } else {
            header("Location: ../views/employee_views/updateProduct.php?productId=" . $productId . "&genErr=" . urlencode("Failed to update product"));
        }
    } elseif ($action == "delete") {
        $productId = isset($_POST["productId"]) ? intval($_POST["productId"]) : 0;
        
        $result = deleteProduct($productId);
        
        if ($result) {
            header("Location: ../views/employee_views/manageProducts.php?success=" . urlencode("Product deleted successfully"));
        } else {
            header("Location:  ../views/employee_views/manageProducts.php?genErr=" . urlencode("Failed to delete product"));
        }
    }
}
?>
