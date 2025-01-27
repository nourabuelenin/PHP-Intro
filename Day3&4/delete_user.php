<?php
session_start();

// Redirect to login if not logged in
if (!isset($_SESSION['user'])) {
    header("Location: index.php?action=login");
    exit();
}

// Include database connection
require 'database.php';

// Delete user
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "DELETE FROM users WHERE id = $id";
    if (mysqli_query($connection, $sql)) {
        header("Location: users.php");
    } else {
        echo "Error deleting record: " . mysqli_error($connection);
    }
}
?>