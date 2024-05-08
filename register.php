<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Registration</title>
	<link rel="stylesheet" href="style.css">
</head>
<body>
    <h2>User Registration</h2>
    <form action="register.php" method="post" enctype="multipart/form-data">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required><br><br>
        
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required><br><br>
        
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required><br><br>
        
        <label for="file">Upload File:</label>
        <input type="file" id="file" name="file" required><br><br>
        
        <button type="submit" name="register">Register</button>
		<button onclick="location.href='login.php'">Login</button>
    </form>
</body>
</html>
<?php
session_start();
// Include helper functions
include 'helpers.php';

if (isset($_POST['register'])) {
	try {
		$username = $_POST['username'];
        $password = $_POST['password'];
        $email = $_POST['email'];
        $file = $_FILES['file'];
		
		// Validate input fields
        if (empty($username) || empty($password) || empty($email) || empty($file['name'])) {
            throw new Exception("All fields are required!");
        }

        // Validate email format
        if (!validateEmail($email)) {
            throw new Exception("Invalid email format!");
        }
		
		// Check if username or email already exists
        if (userExists($username, $email)) {
            throw new Exception("Username or email already exists!");
        }

        // Upload file
        $uploadPath = 'uploads/' . basename($file['name']);
        if (!move_uploaded_file($file['tmp_name'], $uploadPath)) {
            throw new Exception("File upload failed!");
        }
		
		// Insert user data into database
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);
        if (insertUser($username, $passwordHash, $email, $uploadPath)) {
            echo "Registration successful!";
        } else {
            throw new Exception("Error inserting user data!");
        }
		
	} catch (Exception $e) {
        // Log error message
        logMessage($e->getMessage());
        // Display error message to user
        echo "An error occurred during registration. Please try again later.";
    }
}
?>
