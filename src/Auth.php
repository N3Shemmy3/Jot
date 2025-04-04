<?php
include('./Connection.php');
include('./Responses.php');

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
