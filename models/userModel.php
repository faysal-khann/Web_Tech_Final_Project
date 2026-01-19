<?php
require_once("dbConnect.php");

function authUser($email, $pass)
{
    $conn = dbConnect();
    $email = mysqli_real_escape_string($conn, $email);
    $pass = mysqli_real_escape_string($conn, $pass);
    
    $query = "SELECT * FROM users WHERE email='$email' AND password='$pass'";
    $data = mysqli_query($conn, $query);
    $user = null;
    
    if (mysqli_num_rows($data) > 0) {
        $user = mysqli_fetch_assoc($data);
    }
    
    return $user;
}

function registerUser($email, $password, $firstName, $lastName, $phone, $address, $role)
{
    $conn = dbConnect();
    $email = mysqli_real_escape_string($conn, $email);
    $password = mysqli_real_escape_string($conn, $password);
    $firstName = mysqli_real_escape_string($conn, $firstName);
    $lastName = mysqli_real_escape_string($conn, $lastName);
    $phone = mysqli_real_escape_string($conn, $phone);
    $address = mysqli_real_escape_string($conn, $address);
    
    $status = ($role == 3) ? 'active' : 'pending';
    
    $query = "INSERT INTO users (email, password, firstName, lastName, phone, address, role, status) 
              VALUES ('$email', '$password', '$firstName', '$lastName', '$phone', '$address', $role, '$status')";
    
    mysqli_query($conn, $query);
    return mysqli_affected_rows($conn) > 0;
}

function emailExists($email)
{
    $conn = dbConnect();
    $email = mysqli_real_escape_string($conn, $email);
    $query = "SELECT userId FROM users WHERE email='$email'";
    $data = mysqli_query($conn, $query);
    return mysqli_num_rows($data) > 0;
}


?>