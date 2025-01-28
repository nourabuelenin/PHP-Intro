<?php
$host = 'localhost';      // Host name
$user = 'root';           // Database username
$password = '2001';       // Database password
$database = 'user_system'; // Database name

try {
    $connection = mysqli_connect($host, $user, $password, $database);
    if (!$connection) {
        throw new Exception("Connection failed: " . mysqli_connect_error());
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>