<?php
// Database connection
$servername = "localhost";
$username = "root"; // Default XAMPP username
$password = "antra123"; // Default XAMPP password
$dbname = "ayurveda_clinic";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
