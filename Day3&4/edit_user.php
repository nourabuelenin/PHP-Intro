<?php
session_start();

// Redirect to login if not logged in
if (!isset($_SESSION['user'])) {
    header("Location: index.php?action=login");
    exit();
}

// Include database connection
require 'database.php';

// Fetch user data for editing
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM users WHERE id = $id";
    $result = mysqli_query($connection, $sql);
    $user = mysqli_fetch_assoc($result);
}

// Update user data
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $room = $_POST['room'];

    $sql = "UPDATE users SET name = '$name', email = '$email', room = '$room' WHERE id = $id";
    if (mysqli_query($connection, $sql)) {
        header("Location: users.php");
    } else {
        echo "Error updating record: " . mysqli_error($connection);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
</head>
<body>

<h2>Edit User</h2>
<form method="post">
    <input type="hidden" name="id" value="<?php echo $user['id']; ?>">
    <label>Name:</label>
    <input type="text" name="name" value="<?php echo $user['name']; ?>" required><br><br>
    <label>Email:</label>
    <input type="email" name="email" value="<?php echo $user['email']; ?>" required><br><br>
    <label>Room No:</label>
    <select name="room">
        <option value="Application1" <?php echo ($user['room'] == 'Application1') ? 'selected' : ''; ?>>Application1</option>
        <option value="Application2" <?php echo ($user['room'] == 'Application2') ? 'selected' : ''; ?>>Application2</option>
        <option value="Cloud" <?php echo ($user['room'] == 'Cloud') ? 'selected' : ''; ?>>Cloud</option>
    </select><br><br>
    <button type="submit">Update</button>
</form>

<a href="users.php">Back to Users</a>

</body>
</html>