<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h2>Registration</h2>
    <form action="registeration.php" method="POST">
        <label for="first_name">First Name:</label>
        <input type="text" id="first_name" name="first_name"><br><br>

        <label for="last_name">Last Name:</label>
        <input type="text" id="last_name" name="last_name"><br><br>

        <label for="address">Address:</label><br>
        <textarea id="address" name="address" rows="4" cols="30"></textarea><br><br>

        <label for="country">Country:</label>
        <select id="country" name="country">
            <option value="egypt">Egypt</option>
            <option value="other">Other</option>
        </select><br><br>

        <label>Gender:</label>
        <input type="radio" name="gender" value="male">Male
        <input type="radio" name="gender" value="female">Female<br><br>

        <label>Skills:</label>
        <input type="checkbox" name="skills[]" value="PHP"> PHP
        <input type="checkbox" name="skills[]" value="MySQL"> MySQL
        <input type="checkbox" name="skills[]" value="J2SE"> J2SE
        <input type="checkbox" name="skills[]" value="PostgreSQL"> PostgreSQL<br><br>

        <label for="username">Username:</label>
        <input type="text" id="username" name="username" ><br><br>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" ><br><br>

        <label for="department">Department:</label>
        <input type="text" id="department" name="department"><br><br>

        <label for="captcha">Please insert the code below:</label>
        <input type="text" id="captcha" name="captcha" ><br><br>
        
        <input type="submit" value="Submit">
        <input type="reset" value="Reset">
    </form>
</body>
</html>