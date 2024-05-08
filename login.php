<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Login</title>
	<link rel="stylesheet" href="style.css">
</head>
<body>
    <h2>User Login</h2>
    <form action="login.php" method="post">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required><br><br>
        
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required><br><br>
        
        <button type="submit" name="login">Login</button>
		
		<button onclick="location.href='register.php'">Register</button>
    </form>
</body>
</html>
<?php
session_start();

// Include helper functions
include 'helpers.php';

if (isset($_POST['login'])) {
    try {
        $username = $_POST['username'];
        $password = $_POST['password'];

        // Fetch user from the database
        $user = fetchUser($username);
        if ($user) {
            if (password_verify($password, $user['password'])) {
                $_SESSION['username'] = $username;
                header('Location: dashboard.php');
            } else {
                throw new Exception("Incorrect password!");
            }
        } else {
            throw new Exception("User not found!");
        }
    } catch (Exception $e) {
        // Log error message
        logMessage($e->getMessage());
        // Display error message to user
        echo "An error occurred during login. Please try again later.";
    }
}
?>

