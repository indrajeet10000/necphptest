<?php
// Function to establish database connection
function connectDB() {
    $conn = new mysqli('localhost', 'root', '', 'user_management');
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    return $conn;
}

// Function to log messages to a file
function logMessage($message) {
    $logFile = 'error.log';
    file_put_contents($logFile, date('Y-m-d H:i:s') . ' - ' . $message . PHP_EOL, FILE_APPEND);
}

// Function to validate email format
function validateEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

// Function to check if username or email already exists
function userExists($username, $email) {
    $conn = connectDB();
    $checkQuery = "SELECT * FROM users WHERE username=? OR email=?";
    $stmt = $conn->prepare($checkQuery);
    $stmt->bind_param("ss", $username, $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();
    $conn->close();
    return $result->num_rows > 0;
}

// Function to insert user data into the database
function insertUser($username, $passwordHash, $email, $uploadPath) {
    $conn = connectDB();
    $insertQuery = "INSERT INTO users (username, password, email, file_path) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($insertQuery);
    $stmt->bind_param("ssss", $username, $passwordHash, $email, $uploadPath);
    $result = $stmt->execute();
    $stmt->close();
    $conn->close();
    return $result;
}

// Function to fetch user from the database
function fetchUser($username) {
    $conn = connectDB();
    $query = "SELECT * FROM users WHERE username=?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    $stmt->close();
    $conn->close();
    return $user;
}
?>
