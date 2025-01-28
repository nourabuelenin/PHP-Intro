<?php
session_start();
require_once 'database.php'; 

// Redirect to login if not logged in
if (!isset($_SESSION['user'])) {
    header("Location: index.php?action=login");
    exit();
}

// Retrieve the logged-in user's name from the session
$logged_in_user = $_SESSION['user'];

// Query the database to find the user's profile picture URL
$query = "SELECT profile_picture FROM users WHERE name = ?";
$stmt = $connection->prepare($query);
$stmt->bind_param("s", $logged_in_user);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($profile_picture_path);
$stmt->fetch();
$stmt->close();
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

<a href="logout.php">Logout</a>

</body>
</html>