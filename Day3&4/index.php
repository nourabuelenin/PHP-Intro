<?php
session_start();
require_once 'database.php';

define('PRIVATE_KEY', 'your_private_key_here');

// Redirect to welcome page if already logged in
if (isset($_SESSION['user'])) {
    header("Location: welcome.php");
    exit();
}

// Custom hashing function
function custom_hash($password, $salt) {
    $combined = $password . $salt . PRIVATE_KEY;
    return hash('sha256', $combined);
}

// Generate a unique salt
function generate_salt() {
    return bin2hex(random_bytes(16));
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require "handlers/registerHandler.php";
    require "handlers/loginHandler.php";
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
