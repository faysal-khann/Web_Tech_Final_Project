<?php
require_once("../models/userModel.php");

header("Content-Type: application/json");

if (isset($_GET['email'])) {
    $email = trim($_GET['email']);

    if (empty($email)) {
        echo json_encode([
            "status" => "error",
            "message" => ""
        ]);
        exit();
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode([
            "status" => "error",
            "message" => "Invalid email format"
        ]);
        exit();
    }

    if (emailExists($email)) {
        echo json_encode([
            "status" => "exists",
            "message" => "✔ Email found"
        ]);
    } else {
        echo json_encode([
            "status" => "not_found",
            "message" => "✖ Email not registered"
        ]);
    }
}
