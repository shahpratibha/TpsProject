<?php

// session_start();

// // Check if the user is logged in
// if (!isset($_SESSION['user_id'])) {
//     // Redirect to the login page or display an error message
//     header("Location: login.php");
//     exit();
// }

// // Retrieve the user ID or username from the session
// $userN = $_SESSION['username'];
// // Perform the database connection
// // Replace the following with your own database connection code
// $servername = "localhost";
// $username = "root";
// $password = "";
// $dbname = "jfsa";

// $conn = new mysqli($servername, $username, $password, $dbname);
// if ($conn->connect_error) {
//     die("Connection failed: " . $conn->connect_error);
// }

// // Retrieve data from the "locations" table for the respective user
// $sql = "SELECT * FROM locations WHERE username = '$userID'";
// $result = $conn->query($sql);

// // Check if there are any rows in the result
// if ($result->num_rows > 0) {
//     echo "<table>";
//     echo "<tr><th>Name</th><th>Latitude</th><th>Longitude</th></tr>";

//     // Loop through each row in the result
//     while ($row = $result->fetch_assoc()) {
//         echo "<tr>";
//         echo "<td><a href='#' onclick='zoomToLocation(" . $row["latitude"] . ", " . $row["longitude"] . ")'>" . $row["name"] . "</a></td>";
//         echo "<td>" . $row["latitude"] . "</td>";
//         echo "<td>" . $row["longitude"] . "</td>";
//         echo "</tr>";
//     }

//     echo "</table>";
// } else {
//     echo "No locations found for the respective user.";
// }

// // Close the result and database connection
// $result->close();
// $conn->close();
?>
