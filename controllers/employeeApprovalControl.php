<?php
session_start();
require_once("../models/userModel.php");

if (!isset($_SESSION['userId']) || $_SESSION['role'] != 1) {
    header("Location:  ../views/login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $employeeId = isset($_POST["employeeId"]) ? intval($_POST["employeeId"]) : 0;
    $action = isset($_POST["action"]) ? $_POST["action"] :  "";
    
    if ($employeeId > 0 && ($action == "approve" || $action == "reject")) {
        $status = ($action == "approve") ? "active" : "rejected";
        $result = updateEmployeeStatus($employeeId, $status);
        
        if ($result) {
            header("Location: ../views/admin_views/employeeApproval.php?success=" . urlencode("Employee " . $action . "d successfully"));
        } else {
            header("Location: ../views/admin_views/employeeApproval.php?genErr=" . urlencode("Failed to " . $action . " employee"));
        }
    } else {
        header("Location: ../views/admin_views/employeeApproval.php?genErr=" .  urlencode("Invalid request"));
    }
}
?>