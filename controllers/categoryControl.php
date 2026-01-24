<?php
session_start();
require_once("../models/categoryModel.php");

if (!isset($_SESSION['userId']) || $_SESSION['role'] != 1) {
    header("Location: ../views/login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $action = isset($_POST["action"]) ? $_POST["action"] : "";
    
    if ($action == "add") {
        $categoryName = isset($_POST["categoryName"]) ? trim($_POST["categoryName"]) : "";
        $description = isset($_POST["description"]) ? trim($_POST["description"]) : "";
        
        if (empty($categoryName)) {
            header("Location: ../views/admin_views/addCategory.php?nameErr=" . urlencode("Category name is required"));
            exit();
        }
        
        if (categoryExists($categoryName)) {
            header("Location: ../views/admin_views/addCategory.php?nameErr=" . urlencode("Category already exists"));
            exit();
        }
        
        $result = addCategory($categoryName, $description);
        
        if ($result) {
            header("Location: ../views/admin_views/manageCategories.php?success=" . urlencode("Category added successfully"));
        } else {
            header("Location: ../views/admin_views/addCategory.php?genErr=" . urlencode("Failed to add category"));
        }
    } elseif ($action == "update") {
        $categoryId = isset($_POST["categoryId"]) ? intval($_POST["categoryId"]) : 0;
        $categoryName = isset($_POST["categoryName"]) ? trim($_POST["categoryName"]) : "";
        $description = isset($_POST["description"]) ? trim($_POST["description"]) : "";
        
        if (empty($categoryName)) {
            header("Location: ../views/admin_views/manageCategories.php?nameErr=" . urlencode("Category name is required"));
            exit();
        }
        
        $result = updateCategory($categoryId, $categoryName, $description);
        
        if ($result) {
            header("Location: ../views/admin_views/manageCategories.php?success=" . urlencode("Category updated successfully"));
        } else {
            header("Location: ../views/admin_views/manageCategories.php? genErr=" . urlencode("Failed to update category"));
        }
    } elseif ($action == "delete") {
        $categoryId = isset($_POST["categoryId"]) ? intval($_POST["categoryId"]) : 0;
        
        $result = deleteCategory($categoryId);
        
        if ($result) {
            header("Location: ../views/admin_views/manageCategories.php?success=" .  urlencode("Category deleted successfully"));
        } else {
            header("Location: ../views/admin_views/manageCategories.php?genErr=" . urlencode("Failed to delete category"));
        }
    }
}
?>