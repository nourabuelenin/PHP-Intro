<?php
session_start();
require 'database.php'; // Include the database connection

// Redirect to login if not logged in or not admin
if (!isset($_SESSION['admin'])) {
    header("Location: index.php?action=login");
    exit();
}

// Handle Delete User
if (isset($_GET['delete_id'])) {
    if ($db->delete('users', $_GET['delete_id'])) {
        echo "<p>User deleted successfully!</p>";
    } else {
        echo "<p>Failed to delete user.</p>";
    }
}

// Handle Edit User
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['edit_user'])) {
    $id = $_POST['id'];
    $fields = [
        'name' => $_POST['name'],
        'email' => $_POST['email'],
        'room' => $_POST['room']
    ];

    if ($db->update('users', $id, $fields)) {
        echo "<p>User updated successfully!</p>";
    } else {
        echo "<p>Failed to update user.</p>";
    }
}

// Fetch all users from the database
$users = $db->select('users', 'id, name, email, room, profile_picture');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Admin Panel</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        .edit-form {
            display: none;
            margin-top: 10px;
        }
        img {
            width: 50px;
            height: 50px;
            border-radius: 50%; /* Optional: Makes the image circular */
        }
    </style>
</head>
<body>

<h2>Admin Panel</h2>
<p>Welcome, Admin!</p>

<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Room</th>
            <th>Profile Picture</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($users as $row): ?>
            <tr>
                <td><?php echo htmlspecialchars($row['id']); ?></td>
                <td><?php echo htmlspecialchars($row['name']); ?></td>
                <td><?php echo htmlspecialchars($row['email']); ?></td>
                <td><?php echo htmlspecialchars($row['room']); ?></td>
                <td>
                    <?php
                    $profile_picture_path = "uploads/" . $row['profile_picture'];
                    if (!empty($row['profile_picture']) && file_exists($profile_picture_path)) {
                        echo '<img src="' . htmlspecialchars($profile_picture_path) . '" alt="Profile Picture">';
                    } else {
                        echo '<img src="default-avatar.png" alt="Default Profile Picture">';
                    }
                    ?>
                </td>
                <td>
                    <button onclick="toggleEditForm(<?php echo $row['id']; ?>)">Edit</button>
                    <a href="admin.php?delete_id=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure you want to delete this user?');">Delete</a>
                </td>
            </tr>
            <!-- Edit Form (Hidden by Default) -->
            <tr id="edit-form-<?php echo $row['id']; ?>" class="edit-form">
                <td colspan="6">
                    <form method="post" action="admin.php">
                        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                        <label>Name:</label>
                        <input type="text" name="name" value="<?php echo htmlspecialchars($row['name']); ?>" required><br><br>
                        <label>Email:</label>
                        <input type="email" name="email" value="<?php echo htmlspecialchars($row['email']); ?>" required><br><br>
                        <label>Room:</label>
                        <input type="text" name="room" value="<?php echo htmlspecialchars($row['room']); ?>" required><br><br>
                        <button type="submit" name="edit_user">Update</button>
                        <button type="button" onclick="toggleEditForm(<?php echo $row['id']; ?>)">Cancel</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<a href="logout.php">Logout</a>

<script>
    // Function to toggle the edit form visibility
    function toggleEditForm(userId) {
        const editForm = document.getElementById(`edit-form-${userId}`);
        if (editForm.style.display === "none" || editForm.style.display === "") {
            editForm.style.display = "table-row";
        } else {
            editForm.style.display = "none";
        }
    }
</script>

</body>
</html>