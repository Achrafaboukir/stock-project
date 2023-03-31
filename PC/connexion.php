<?php
// Set database credentials
$host = 'localhost'; // Replace xxxxxxxx with your ngrok subdomain
$username = 'root'; // Replace with your MySQL username
$password = ''; // Replace with your MySQL password
$dbname = 'circet1';

// Create database connection
$conn = new mysqli($host, $username, $password, $dbname);

// Check for errors
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Set character set
$conn->set_charset("utf8mb4");


// Include this file in other files to use the database connection
?>
