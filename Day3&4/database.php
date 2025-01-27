<?php
$host = 'localhost';      // Host name
$user = 'root';           // Database username
$password = '2001';       // Database password
$database = 'user_system'; // Database name

// Create connection
$connection = mysqli_connect($host, $user, $password);

// Check connection
if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}

// Create database if it doesn't exist
$sql = "CREATE DATABASE IF NOT EXISTS $database";
if (mysqli_query($connection, $sql)) {
    // Select the database
    mysqli_select_db($connection, $database);

    // Create users table if it doesn't exist
    $sql = "CREATE TABLE IF NOT EXISTS users (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(255) NOT NULL,
        email VARCHAR(255) NOT NULL UNIQUE,
        password VARCHAR(255) NOT NULL,
        salt VARCHAR(255) NOT NULL,
        room VARCHAR(255) NOT NULL,
        profile_picture VARCHAR(255) NOT NULL
    )";
    if (!mysqli_query($connection, $sql)) {
        die("Error creating table: " . mysqli_error($connection));
    }
} else {
    die("Error creating database: " . mysqli_error($connection));
}
?>