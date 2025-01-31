<?php
session_start();
require 'database.php'; // Include the database connection

// Redirect to login if not logged in
if (!isset($_SESSION['user'])) {
    header("Location: index.php?action=login");
    exit();
}

// Retrieve the logged-in user's name from the session
$logged_in_user = $_SESSION['user'];

// Query the database to find the user's profile picture URL
$result = $db->select('users', 'profile_picture', "name = '$logged_in_user'");

if (!empty($result)) {
    $profile_picture = $result[0]['profile_picture'];
    $profile_picture_path = "uploads/" . $profile_picture;
} else {
    die("User not found.");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Welcome</title>
</head>
<body>

<h2>Welcome, <?php echo htmlspecialchars($_SESSION['user']); ?>!</h2>

<?php 
// Check if the profile picture exists and display it
if (!empty($profile_picture_path) && file_exists($profile_picture_path)) {
    echo '<img src="' . htmlspecialchars($profile_picture_path) . '" alt="Profile Picture" width="150" height="150">';
} else {
    echo '<p>Profile picture not found. Using default avatar.</p>';
    echo '<img src="default-avatar.png" alt="Default Profile Picture" width="150" height="150">';
}
?>

<p>You have successfully logged in.</p>

<a href="logout.php">Logout</a>

</body>
</html>