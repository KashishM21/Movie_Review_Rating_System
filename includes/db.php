<?php
// Database configuration
$servername = "localhost";   // Hostname
$port = "3306";              // MySQL port (optional)
$username = "phpmyadmin";    // DB username
$password = "root";          // DB password
$dbname = "movieRRsystem";   // Database name

// Create a new MySQLi connection
$mysqli = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}
?>
<link rel="stylesheet" href="style.css"> <!-- Link to CSS -->
