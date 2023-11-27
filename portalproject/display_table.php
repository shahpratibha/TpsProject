<?php
// session_start();

// // Check if the user is logged in
// if (!isset($_SESSION['username'])) {
//     // Redirect to the login page or display an error message
//     header("Location: login.php");
//     exit();
// }

// // Retrieve the user ID or username from the session
// $userN = $_SESSION['username'];

// // Establish database connection
// $servername = "localhost";
// $username = "root";
// $password = "";
// $dbname = "jfsa";

// $conn = new mysqli($servername, $username, $password, $dbname);
// if ($conn->connect_error) {
//     die("Connection failed: " . $conn->connect_error);
// }
// ?>

//  <?php
// // Retrieve data from the "locations" table
// $sql = "SELECT * FROM locations";
// $result = $conn->query($sql);

// // Check if there are any rows in the result
// if ($result->num_rows > 0) {
   
    

//     // Loop through each row in the result
//     while ($row = $result->fetch_assoc()) {
//         echo "<div class='ms-3  d-flex'>";
//         echo "<p class='mb-0 pb-0 '><a href='#' class='text-light   text-decoration-none' onclick='zoomToLocation(" . $row["latitude"] . ", " . $row["longitude"] . ")'>" . $row["name"] . "</a></p>";
//         echo "<p class='d-flex pb-0 mb-0 ms-auto'>      <button class='bg-transparent fs-0 pe-5 border-0 text-secondary' onclick='deleteLocation(" . $row["id"] . ")'><i class='fas fa-trash-alt'></i></button></p>"; // Add delete button
//         echo "</div>";
//     }

   
// } else {
//     echo "No locations found.";
// }

// // Close the result and database connection
// // $result->close();
// // $conn->close();
// ?>

<!-- 
 <button class='bg-transparent  border-0 text-light fs-5' onclick='renameText()'><i class='fas fa-pencil'></i></button> -->