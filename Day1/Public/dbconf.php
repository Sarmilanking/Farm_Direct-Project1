<?php
// Start session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Include session management file
include_once("../resource/session.php");

// Database configuration
$host = '127.0.0.1';
$user = 'root';
$password = 'mariadb'; // Replace with your MySQL root password if necessary
$database = 'Farm';
$port = 3306;

// Establish connection
$conn = mysqli_connect($host, $user, $password, $database, $port);

// Check connection
if (!$conn) {
    die("Database Connection Failed: " . mysqli_connect_error());
}
?>
