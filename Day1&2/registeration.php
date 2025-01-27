<?php
    $_POST;
    var_dump($_POST);
    var_dump($_POST['gender'] === 'female');
    var_dump($_POST['gender'] === 'Female');


    $filename = "customers.txt";

    // if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    //     $newRecord = [
    //         'id' => uniqid('cust_', true), // Unique ID
    //         'firstname' => $_POST['first_name'],
    //         'lastname' => $_POST['last_name'],
    //         'address' => $_POST['address'],
    //         'country' => $_POST['country'],
    //         'gender' => $_POST['gender'] ?? 'not specified',
    //         'skills' => implode(', ', $_POST['skills'] ?? []), // Empty array fallback
    //         'username' => $_POST['username'],
    //         'password' => $_POST['password'],
    //         'department' => $_POST['department']
    //     ];
    
    //     file_put_contents($filename, json_encode($newRecord, JSON_UNESCAPED_UNICODE) . PHP_EOL, FILE_APPEND);
    //     header("Location: accounts.php");
    //     exit();
    // }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<?php
    $salutation = "";
    if ($_POST['gender'] == 'Male') {
        $salutation = "Mr.";
    } else {
        $salutation = "Miss";
    }
?>

<h3>Thanks <?= $salutation ?> <?= $_POST['first_name'] ?> <?= $_POST['last_name'] ?></h3>

<h5>Please review your information:</h5>

<p>Name: <?= $_POST['first_name'] ?> <?= $_POST['last_name'] ?></p>
<p>Address: <?= $_POST['address'] ?></p>
<p>Country: <?= $_POST['country'] ?></p>
<p>Gender: <?= $_POST['gender'] ?></p>
<p>Skills: <?= isset($_POST['skills']) ?></p>
<p>Department: <?= $_POST['department'] ?></p>

</body>
</html>