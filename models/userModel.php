<?php
require_once("dbConnect.php");

function authUser($email, $pass)
{
    $conn = dbConnect();
    $email = mysqli_real_escape_string($conn, $email);
    $pass_entered = mysqli_real_escape_string($conn, $pass);

    //MD 5 Password
    $pass = md5($pass_entered);
    
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

    //MD 5 Password
    $encpassword = md5($password);
    
    
    $status = ($role == 3) ? 'active' : 'pending';
    
    $query = "INSERT INTO users (email, password, firstName, lastName, phone, address, role, status) 
              VALUES ('$email', '$encpassword', '$firstName', '$lastName', '$phone', '$address', $role, '$status')";
    
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


function getUserById($userId)
{
    $conn = dbConnect();
    $query = "SELECT * FROM users WHERE userId=$userId";
    $data = mysqli_query($conn, $query);
    
    if (mysqli_num_rows($data) > 0) {
        return mysqli_fetch_assoc($data);
    }
    return null;
}


function updateUserProfile($userId, $firstName, $lastName, $phone, $address)
{
    $conn = dbConnect();
    $firstName = mysqli_real_escape_string($conn, $firstName);
    $lastName = mysqli_real_escape_string($conn, $lastName);
    $phone = mysqli_real_escape_string($conn, $phone);
    $address = mysqli_real_escape_string($conn, $address);
    
    $query = "UPDATE users SET firstName='$firstName', lastName='$lastName', phone='$phone', address='$address' WHERE userId=$userId";
    mysqli_query($conn, $query);
    return mysqli_affected_rows($conn) >= 0;
}

function deleteUserProfile($userId)
{
    $conn = dbConnect();
    $query = "DELETE FROM users WHERE userId=$userId";
    mysqli_query($conn, $query);
    return mysqli_affected_rows($conn) > 0;
}

function changePassword($userId, $newPassword_before_MD5)
{
    $conn = dbConnect();
    $pass = md5($newPassword_before_MD5);
    $newPassword = mysqli_real_escape_string($conn, $pass);
    $query = "UPDATE users SET password='$newPassword' WHERE userId=$userId";
    mysqli_query($conn, $query);
    return mysqli_affected_rows($conn) > 0;
}

function verifyPassword($userId, $currentPassword_before_MD5)
{
    $conn = dbConnect();
    $pass = md5($currentPassword_before_MD5);
    $currentPassword = mysqli_real_escape_string($conn, $pass);
    $query = "SELECT userId FROM users WHERE userId=$userId AND password='$currentPassword'";
    $data = mysqli_query($conn, $query);
    return mysqli_num_rows($data) > 0;
}


?>