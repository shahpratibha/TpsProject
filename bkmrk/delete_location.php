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

// Check if the ID parameter is set
if (isset($_POST['id'])) {
    $locationId = $_POST['id'];

    // Delete the location from the database
    $sql = "DELETE FROM locations WHERE id = '$locationId'";
    if ($conn->query($sql) === TRUE) {
        echo "Location deleted successfully";
    } else {
        echo "Error deleting location: " . $conn->error;
    }
} else {
    echo "Invalid location ID";
}

$conn->close();
?>
