<?php
$host = "localhost";
$user = "root";
$password = "";
$database = "faculty_evaluation";
$port = 3307;

// Create connection
$conn = mysqli_connect($host, $user, $password, $database, $port);

// Check connection
if (!$conn) {
    die("Database Connection Failed: " . mysqli_connect_error());
}

// Optional: set charset (recommended)
mysqli_set_charset($conn, "utf8mb4");
?>