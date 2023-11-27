<script>console.log("hi");</script>
<?php
// Assuming you have established a database connection

session_start(); // Start the session

// Assuming you are using MySQL database
$servername = 'localhost';
$username = 'phpmyadmin';
$password = 'Sagar@992101';
$dbname = 'jfsa';

// Create a new database connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}

$data = json_decode(file_get_contents("php://input"), true);
$query = $data["query"];
$username = $data["username"];
// echo "Hello, " . $data["query"] . "!";
// echo PHP_EOL;
// echo "Your email address is " . $data["username"];
// $sql = "INSERT INTO locations (latitude, longitude, name) VALUES ('$lat', '$lng', '$name')";
$sql = "INSERT INTO searches (user_name, search_query)
VALUES ('$username', '$query')";
echo ("hi");

if ($conn->query($sql) === TRUE) {
    // echo "New record created successfully";
} else {
    // echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
