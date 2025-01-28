<?php


if (isset($_POST['login'])) {
        $email = $_POST['email'];
        $password = $_POST['password'];

        $query = "SELECT name, password, salt, profile_picture FROM users WHERE email = ?";
        $stmt = $connection->prepare($query);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($name, $stored_password, $salt, $profile_picture);

        if ($stmt->fetch()) {
            // Hash the entered password using the stored salt
            $hashed_password = custom_hash($password, $salt);

            // Compare the hashed passwords
            if ($hashed_password === $stored_password) {
                $_SESSION['user'] = $name;
                $_SESSION['profile_picture'] = "uploads/" . $profile_picture;
                header("Location: welcome.php");
                exit();
            }
        }
        echo "Invalid login credentials.";
        $stmt->close();
   }
?>
