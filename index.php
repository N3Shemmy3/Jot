<?php
include('./src/Auth.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'];
    $username = $_POST['username'];
    $password = $_POST['password'];

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
