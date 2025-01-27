<?php
// Handle delete action
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_id'])) {
    $targetId = $_POST['delete_id'];
    $filename = "customers.txt";
    
    if (file_exists($filename)) {
        $lines = file($filename, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        $newLines = [];
        
        foreach ($lines as $line) {
            $customer = json_decode($line, true);
            if ($customer && ($customer['id'] ?? '') !== $targetId) {
                $newLines[] = $line;
            }
        }
        
        file_put_contents($filename, implode(PHP_EOL, $newLines));
    }
    header("Location: accounts.php");
    exit();
}

// Read and display records
$filename = "customers.txt";
$customers = [];

if (file_exists($filename)) {
    $lines = file($filename, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        $customer = json_decode($line, true);
        if ($customer !== null) {
            $customers[] = $customer;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="table.css" >
    <title>Document</title>
</head>
<body>
<h2>Customer Records</h2>
    <table>
        <thead>
            <tr>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Address</th>
                <th>Country</th>
                <th>Gender</th>
                <th>Skills</th>
                <th>Username</th>
                <th>Department</th>
            </tr>
        </thead>
        <tbody>
        <?php if (!empty($customers)): ?>
            <?php foreach($customers as $customer): ?>
                <tr>
                    <td><?= $customer['firstname'] ?></td>
                    <td><?= $customer['lastname'] ?></td>
                    <td><?= $customer['address'] ?></td>
                    <td><?= $customer['country'] ?></td>
                    <td><?= $customer['gender'] ?></td>
                    <td><?= $customer['skills'] ?></td>
                    <td><?= $customer['username'] ?></td>
                    <td><?= $customer['department'] ?></td>
                    <td>
                            <form method="POST" onsubmit="return confirm('Delete this customer?')">
                                <input type="hidden" name="delete_id" 
                                       value="<?= $customer['id'] ?? '' ?>">
                                <button type="submit" class="delete-btn">Delete</button>
                            </form>
                        </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="8">No records found</td>
            </tr>
        <?php endif; ?>
        </tbody>
    </table>
</body>
</html>