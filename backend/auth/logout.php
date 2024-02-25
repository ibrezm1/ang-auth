<?php
session_start();

// Enable CORS
header("Access-Control-Allow-Origin: http://localhost:4200");
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Headers: Content-Type");

// Check request method
$requestMethod = $_SERVER['REQUEST_METHOD'];

switch ($requestMethod) {
    case 'GET':
        // Logout Operation
        if (isset($_SESSION['loggedIn'])) {
            unset($_SESSION['loggedIn']);
            unset($_SESSION['user']);
            echo json_encode(['loggedIn' => false, 'success' => true, 'message' => 'Logout successful']);
        } else {
            echo json_encode(['loggedIn' => false, 'success' => false, 'message' => 'Not logged in']);
        }
        break;

    default:
        echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}
?>
