<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$host = "localhost";
$user = "root";
$passwordn = "";
$dbName = "gadgetgrid";
$port = 3306;

function dbConnect()
{
    global $host, $user, $passwordn, $dbName, $port;
    $conn = mysqli_connect($host, $user, $passwordn, $dbName, $port);

    if (!$conn) {
        die("Connection failed: ".mysqli_connect_error());
    }

    return $conn;
}
?>