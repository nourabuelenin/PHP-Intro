<?php
session_start();

// Redirect to welcome page if already logged in
if (isset($_SESSION['user'])) {
    header("Location: welcome.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
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

        // Validate profile picture
        $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif'];
        $file_extension = strtolower(pathinfo($profile_picture['name'], PATHINFO_EXTENSION));

        if (!in_array($file_extension, $allowed_extensions)) {
            die("Only image files are allowed.");
        }

        move_uploaded_file($profile_picture['tmp_name'], "uploads/" . $profile_picture['name']);

        // Save user data
        $user_data = implode(",", [$name, $email, $password, $room]) . "\n";
        file_put_contents("users.txt", $user_data, FILE_APPEND);
        echo "Registration successful! <a href='index.php?action=login'>Login here</a>";
    }

    if (isset($_POST['login'])) {
        $email = $_POST['email'];
        $password = $_POST['password'];

        $users = file("users.txt", FILE_IGNORE_NEW_LINES);
        foreach ($users as $user) {
            list($name, $stored_email, $stored_password, $room) = explode(",", $user);
            if ($email == $stored_email && $password == trim($stored_password)) {
                $_SESSION['user'] = $name;
                header("Location: welcome.php");
                exit();
            }
        }
        echo "Invalid login credentials.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User System</title>
</head>
<body>

<?php if (isset($_GET['action']) && $_GET['action'] == "login"): ?>
    <h2>Login</h2>
    <form method="post">
        <label>Email:</label>
        <input type="email" name="email" required><br><br>

        <label>Password:</label>
        <input type="password" name="password" required><br><br>

        <button type="submit" name="login">Login</button>
    </form>
    <a href="index.php">Register here</a>

<?php else: ?>
    <h2>Add User</h2>
    <form action="index.php" method="post" enctype="multipart/form-data">
        <label>Name:</label>
        <input type="text" name="name" required><br><br>

        <label>Email:</label>
        <input type="email" name="email" required><br><br>

        <label>Password:</label>
        <input type="password" name="password" required><br><br>

        <label>Confirm Password:</label>
        <input type="password" name="confirm_password" required><br><br>

        <label>Room No:</label>
        <select name="room">
            <option value="Application1">Application1</option>
            <option value="Application2">Application2</option>
            <option value="Cloud">Cloud</option>
        </select><br><br>

        <label>Profile Picture:</label>
        <input type="file" name="profile_picture" required><br><br>

        <button type="submit" name="register">Save</button>
        <button type="reset">Reset</button>
    </form>
    <a href="index.php?action=login">Already have an account? Login here</a>
<?php endif; ?>

</body>
</html>
