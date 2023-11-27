<?php
session_start(); // Start the session

// Connect to your database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "data";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the user is logged in or authenticated
if (!isset($_SESSION['username'])) {
    // User not authenticated, return an error response
    $response = array('error' => 'User not authenticated');
    echo json_encode($response);
    exit();
}

// Get the logged-in user's username from the session
$userN = $_SESSION['username'];

// Retrieve locations for the logged-in user from the database
$stmt = $conn->prepare("SELECT * FROM locations WHERE username = ?");
$stmt->bind_param("s", $userN);
$stmt->execute();
$result = $stmt->get_result();
$locations = array();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $locations[] = $row;
    }
}

$stmt->close();
$conn->close();

// Set the response header to JSON
header('Content-Type: application/json');

// Return locations as JSON response
echo json_encode($locations);
?>
