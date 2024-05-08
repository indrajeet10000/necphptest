<?php
// Start the session
session_start();

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    // Redirect to the login page if not logged in
    header('Location: login.php');
    exit; // Make sure to exit after redirection
}

// Now you can safely access $_SESSION['username']
$username = $_SESSION['username'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
	<link rel="stylesheet" href="style.css">
</head>
<body>
    <h2>Welcome, <?php echo $username; ?>!</h2>
    <a href="logout.php">Logout</a>
</body>
</html>
