// welcome.php
<?php
session_start();

// Redirect to login if not logged in
if (!isset($_SESSION['user'])) {
    header("Location: index.php?action=login");
    exit();
}

// Include database connection
require 'database.php';

// Fetch the logged-in user's details
$logged_in_email = $_SESSION['email'];
$sql = "SELECT is_admin FROM users WHERE email = '$logged_in_email'";
$result = mysqli_query($connection, $sql);
$user = mysqli_fetch_assoc($result);

// Retrieve the logged-in user's name from the session
$logged_in_user = $_SESSION['user'];

// Read the users.txt file to find the user's profile picture URL
$users = file("users.txt", FILE_IGNORE_NEW_LINES);
$profile_picture_path = "";

foreach ($users as $user) {
    list($name, $email, $password, $room, $profile_picture) = explode(",", $user);
    if ($logged_in_user === $name) {
        $profile_picture_path = $profile_picture;
        break;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome</title>
</head>
<body>

<h2>Welcome, <?php echo htmlspecialchars($_SESSION['user']); ?>!</h2>
<?php 
if (!empty($profile_picture_path) && file_exists($profile_picture_path)) {
    echo '<img src="' . htmlspecialchars($profile_picture_path) . '" alt="Profile Picture" width="150" height="150">';
} else {
    echo '<img src="default-avatar.png" alt="Default Profile Picture" width="150" height="150">';
}
?>
<p>You have successfully logged in.</p>

<!-- Show the link to users.php only for admin -->
<?php if ($user['is_admin']): ?>
    <a href="users.php">View All Users</a>
<?php endif; ?>

<a href="logout.php">Logout</a>

</body>
</html>