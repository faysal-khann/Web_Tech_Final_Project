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

function changePassword($userId, $newPassword)
{
    $conn = dbConnect();
    $newPassword = mysqli_real_escape_string($conn, $newPassword);
    $query = "UPDATE users SET password='$newPassword' WHERE userId=$userId";
    mysqli_query($conn, $query);
    return mysqli_affected_rows($conn) > 0;
}

function verifyPassword($userId, $currentPassword)
{
    $conn = dbConnect();
    $currentPassword = mysqli_real_escape_string($conn, $currentPassword);
    $query = "SELECT userId FROM users WHERE userId=$userId AND password='$currentPassword'";
    $data = mysqli_query($conn, $query);
    return mysqli_num_rows($data) > 0;
}

function getPendingEmployees()
{
    $conn = dbConnect();
    $query = "SELECT * FROM users WHERE role=2 AND status='pending'";
    $data = mysqli_query($conn, $query);
    
    $employees = [];
    while ($row = mysqli_fetch_assoc($data)) {
        $employees[] = $row;
    }
    return $employees;
}

function updateEmployeeStatus($userId, $status)
{
    $conn = dbConnect();
    $status = mysqli_real_escape_string($conn, $status);
    $query = "UPDATE users SET status='$status' WHERE userId=$userId AND role=2";
    mysqli_query($conn, $query);
    return mysqli_affected_rows($conn) > 0;
}

function getUsersByRole($role)
{
    $conn = dbConnect();
    $query = "SELECT * FROM users WHERE role=$role";
    $data = mysqli_query($conn, $query);
    
    $users = [];
    while ($row = mysqli_fetch_assoc($data)) {
        $users[] = $row;
    }
    return $users;
}

function getAllCustomers()
{
    return getUsersByRole(3);
}

function getAllEmployees()
{
    $conn = dbConnect();
    $query = "SELECT * FROM users WHERE role=2 AND status='active'";
    $data = mysqli_query($conn, $query);
    
    $employees = [];
    while ($row = mysqli_fetch_assoc($data)) {
        $employees[] = $row;
    }
    return $employees;
}

function addCustomer($email, $password, $firstName, $lastName, $phone, $address)
{
    return registerUser($email, $password, $firstName, $lastName, $phone, $address, 3);
}

function removeCustomer($customerId)
{
    $conn = dbConnect();
    $query = "DELETE FROM users WHERE userId=$customerId AND role=3";
    mysqli_query($conn, $query);
    return mysqli_affected_rows($conn) > 0;
}

function deleteUserProfile($userId)
{
    $conn = dbConnect();
    $query = "DELETE FROM users WHERE userId=$userId";
    mysqli_query($conn, $query);
    return mysqli_affected_rows($conn) > 0;
}
?>