<?php
session_start();

// Redirect to login if not logged in
if (!isset($_SESSION['user'])) {
    header("Location: index.php?action=login");
    exit();
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

<h2>Welcome, <?php echo $_SESSION['user']; ?>!</h2>`
<?php 
if (isset($_SESSION['profile_picture'])) {
    echo '<img src="' . $_SESSION['profile_picture'] . '" alt="Profile Picture" width="150" height="150">';
} else {
    echo '<img src="default-avatar.png" alt="Default Profile Picture" width="150" height="150">';
}
?><p>You have successfully logged in.</p>

<a href="logout.php">Logout</a>

</body>
</html>
