// users.php
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
$logged_in_email = $_SESSION['email']; // Assuming you store the email in the session
$sql = "SELECT is_admin FROM users WHERE email = '$logged_in_email'";
$result = mysqli_query($connection, $sql);
$user = mysqli_fetch_assoc($result);

// Check if the user is an admin
if (!$user || $user['is_admin'] != TRUE) {
    // Redirect non-admin users to welcome.php
    header("Location: welcome.php");
    exit();
}

// Fetch all users from the database
$sql = "SELECT * FROM users";
$result = mysqli_query($connection, $sql);
$users = mysqli_fetch_all($result, MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Users</title>
</head>
<body>

<h2>All Users</h2>
<table border="1">
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Email</th>
        <th>Room</th>
        <th>Profile Picture</th>
        <th>Actions</th>
    </tr>
    <?php foreach ($users as $user): ?>
    <tr>
        <td><?php echo $user['id']; ?></td>
        <td><?php echo $user['name']; ?></td>
        <td><?php echo $user['email']; ?></td>
        <td><?php echo $user['room']; ?></td>
        <td><img src="<?php echo $user['profile_picture']; ?>" alt="Profile Picture" width="50" height="50"></td>
        <td>
            <a href="edit_user.php?id=<?php echo $user['id']; ?>">Edit</a>
            <a href="delete_user.php?id=<?php echo $user['id']; ?>" onclick="return confirm('Are you sure?')">Delete</a>
        </td>
    </tr>
    <?php endforeach; ?>
</table>

<a href="welcome.php">Back to Welcome</a>

</body>
</html>