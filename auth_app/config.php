<?php
session_start();

$host = 'localhost';
$db   = 'auth_app';
$user = 'root';
$pass = ''; // Use your MySQL root password

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
