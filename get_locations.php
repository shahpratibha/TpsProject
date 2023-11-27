<?php
// Connect to your database
$servername = "localhost";
$username = "phpmyadmin";
$password = "Sagar@992101";
$dbname = "jfsa";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve all locations from the database
$sql = "SELECT * FROM locations";
$result = $conn->query($sql);
$locations = array();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $locations[] = $row;
    }
}

$conn->close();

// Set the response header to JSON
header('Content-Type: application/json');

// Return locations as JSON response
echo json_encode($locations);
?>
