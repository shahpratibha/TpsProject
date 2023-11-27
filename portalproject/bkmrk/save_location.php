<?php
// Connect to your database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "data";


$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the latitude, longitude, and name from the AJAX request
$lat = $_POST['lat'];
$lng = $_POST['lng'];
$name = $_POST['name'];
$userN = $_POST['userN'];


// Insert the location into the database
$sql = "INSERT INTO locations (latitude, longitude, name, username) VALUES ('$lat', '$lng', '$name', '$userN')";
if ($conn->query($sql) === TRUE) {
    echo "Location saved successfully.";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>