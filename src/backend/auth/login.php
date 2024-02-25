<?php
session_start();

// Include the configuration file
include '../db_config.php';

// Enable CORS
header("Access-Control-Allow-Origin: http://localhost:4200");
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Methods: GET, POST");
header("Access-Control-Allow-Headers: Content-Type");

// Check request method
$requestMethod = $_SERVER['REQUEST_METHOD'];

switch ($requestMethod) {
    case 'POST':
        // Login Operation
        $data = json_decode(file_get_contents("php://input"), true);

        if (isset($data['username']) && isset($data['password'])) {
            $username = $data['username'];
            $password = $data['password'];

            // Check user credentials (replace with your authentication logic)
            if ($username === 'user' && $password === 'pass') {
                $_SESSION['loggedIn'] = true;
                $_SESSION['user'] = $username;
                echo json_encode(['loggedIn' => true, 'message' => 'Login successful']);
            } else {
                echo json_encode(['loggedIn' => false, 'message' => 'Invalid credentials']);
            }
        } else {
            echo json_encode(['loggedIn' => false, 'message' => 'Username and password required']);
        }
        break;

    case 'GET':
        // Check Session Status
        if (isset($_SESSION['user'])) {
            echo json_encode(['loggedIn' => true, 'username' => $_SESSION['user']]);
        } else {
            echo json_encode(['loggedIn' => false, 'username' => null]);
        }
        break;

    default:
        echo json_encode(['loggedIn' => false, 'message' => 'Invalid request method']);
}

$conn->close();
?>
