<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "resturant";

// Create connection
$conn = new mysqli("localhost", "root", "", "resturant");
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
?>