<?php
$servername = "localhost";
$port="3306";
$username   = "phpmyadmin";  
$password   = "root";        
$dbname     = "movieRRsystem";

$mysqli = new mysqli($servername, $username, $password, $dbname);

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}
?>
<link rel="stylesheet" href="style.css">