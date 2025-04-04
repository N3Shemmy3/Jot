<?php

class Responses
{
    public static function success($message, $data = [])
    {
        http_response_code(200);
        echo json_encode([
            'status' => 'success',
            'message' => $message,
            'data' => $data
        ]);
    }

    public static function error($message, $code = 400)
    {
        http_response_code($code);
        echo json_encode([
            'status' => 'error',
            'message' => $message
        ]);
    }
}

// Database connection details
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "jot";



// Create connection
$conn = new mysqli($servername, $username, $password);

// Check connection
if ($conn->connect_error) {
    die(Responses::error("Connection failed: " . $conn->connect_error));
}

// Create database if it doesn't exist
$sql = "CREATE DATABASE IF NOT EXISTS $dbname";
if ($conn->query($sql) === FALSE) {
    die(Responses::error("An error occurred. Please try again later."));
}

// Select the database
$conn->select_db($dbname);

// Create table if it doesn't exist
$sql = "CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(15) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";
if ($conn->query($sql) === FALSE) {
    die(Responses::error("An error occurred. Please try again later."));
}


// Function to handle user signup
function signup($username, $password)
{
    global $conn;

    // Hash the password for security
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

    // Insert the user into the database
    $stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
    $stmt->bind_param("ss", $username, $hashedPassword);

    if ($stmt->execute()) {
        echo Responses::success("User registered successfully.");
    } else {
        if ($conn->errno === 1062) { // Duplicate  error
            echo Responses::success("Username already exists. Signing in...");
            login($username, $password);
        } else {
            echo Responses::error("Error: " . $conn->error);
        }
    }

    $stmt->close();
}

// Function to handle user login
function login($username, $password)
{
    global $conn;

    // Retrieve the user from the database
    $stmt = $conn->prepare("SELECT password FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($hashedPassword);
        $stmt->fetch();

        // Verify the password
        if (password_verify($password, $hashedPassword)) {
            echo Responses::success("Login successful.");
        } else {
            echo Responses::error("Invalid password.");
        }
    } else {
        echo Responses::error("User not found.");
    }

    $stmt->close();
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['username'], $_POST['password'], $_POST['action'])) {
        echo Responses::error("Missing required fields.");
        return;
    }

    $username = htmlspecialchars(trim($_POST['username']));
    $password = trim($_POST['password']);

    if (strlen($username) > 15 || strlen($password) > 30) {
        echo Responses::error("Invalid input.");
        return;
    }

    $action = $_POST['action'];

    switch ($action) {
        case 'signup':
            signup($username, $password);
            break;
        case 'login':
            login($username, $password);
            break;
        default:
            echo Responses::error("Invalid action.");
            break;
    }
} else {

    if ($conn->connect_error) {
        echo Responses::error("Connection failed: " . $conn->connect_error);
    } else {
        echo Responses::success("Welcome to the Jot api :D");
    }
}
