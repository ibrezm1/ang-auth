<?php
// Start the session
session_start();

// Set the content type to JSON
header('Content-Type: application/json');

// Allow cross-origin resource sharing (CORS)
header("Access-Control-Allow-Origin: http://localhost:4200");
header("Access-Control-Allow-Credentials: true");

// Check if the user is logged in
if (isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] === true) {
    $response = [
        'success' => true,
        'message' => 'User is logged in'
    ];
} else {
    $response = [
        'success' => false,
        'message' => 'User is not logged in'
    ];
}



// Output the response as JSON
echo json_encode($response);
?>
