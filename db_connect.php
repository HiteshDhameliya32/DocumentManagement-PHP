<?php
$servername = "192.185.39.49:3306";  // Database server name
$username = "replyrea_pixcelsythemes";  // Database username
$password = "Hostgator2024!";  // Database password
$dbname = "replyrea_olymel";  // Database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
?>
