<?php
    if (isset($_POST['register'])) {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $confirm_password = $_POST['confirm_password'];
        $room = $_POST['room'];
        $profile_picture = $_FILES['profile_picture'];
        // Email validation (2 ways)
        if (!filter_var($email, FILTER_VALIDATE_EMAIL) || !preg_match("/^[\w]+@[\w]+\.[a-z]{2,4}$/", $email)) {
            die("Invalid email format.");
        }

        // Password validation: 8 chars, only underscores allowed, no uppercase
        if (strlen($password) != 8 || !preg_match('/^[a-z0-9_]+$/', $password) || preg_match('/[A-Z]/', $password)) {
            die("Invalid password format.");
        }

        if ($password !== $confirm_password) {
            die("Passwords do not match.");
        }
        
        // Generate a unique salt for the user
        $salt = generate_salt();

        // Hash the password using the custom hashing function
        $hashed_password = custom_hash($password, $salt);

        // Validate profile picture
        $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif'];
        $file_extension = strtolower(pathinfo($profile_picture['name'], PATHINFO_EXTENSION));

        if (!in_array($file_extension, $allowed_extensions)) {
            die("Only image files are allowed.");
        }

        // Handle file upload
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($profile_picture["name"]);
        if (move_uploaded_file($profile_picture["tmp_name"], $target_file)) {
            // File uploaded successfully
        } else {
            echo "Sorry, there was an error uploading your file.";
            exit();
        }
    
        // Save user data to the database
        $profile_picture_name = $profile_picture['name'];
        $query = "INSERT INTO users (name, email, password, salt, room, profile_picture) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $connection->prepare($query);
        $stmt->bind_param("ssssss", $name, $email, $hashed_password, $salt, $room, $profile_picture_name);
        $stmt->execute();
    
        if ($stmt->affected_rows > 0) {
            echo "Registration successful! <a href='index.php?action=login'>Login here</a>";
        } else {
            echo "Registration failed.";
        }
        $stmt->close();
    }
?>