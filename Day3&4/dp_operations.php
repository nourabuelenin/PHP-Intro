<?php
require_once 'database.php';

function registerUser($name, $email, $password, $room, $profile_picture) {
    global $connection;

    $sql = "INSERT INTO users (name, email, password, room, profile_picture) VALUES (:name, :email, :password, :room, :profile_picture)";
    $stmt = $connection->prepare($sql);

    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':password', $password);
    $stmt->bindParam(':room', $room);
    $stmt->bindParam(':profile_picture', $profile_picture);

    return $stmt->execute();
}

function loginUser($email, $password) {
    global $connection;

    $sql = "SELECT * FROM users WHERE email = :email AND password = :password";
    $stmt = $connection->prepare($sql);

    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':password', $password);

    $stmt->execute();

    return $stmt->fetch(PDO::FETCH_ASSOC);
}
?>