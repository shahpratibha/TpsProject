<?php
session_start();

if (!isset($_SESSION['username'])) {
    $_SESSION['msg'] = "You must log in first";
    header('location: login.php');
}
// Connect to database
$db = mysqli_connect('localhost', 'root', '', 'data');

// Retrieve user details from database
$username = $_SESSION['username'];
$query = "SELECT * FROM users WHERE username='$username'";
$result = mysqli_query($db, $query);
$user = mysqli_fetch_assoc($result);

$userN = $_SESSION['username'];


// -----------------
// $sql = "SELECT * FROM locations  WHERE username = '$username'";
// $result = $db->query($sql);

// $locations = array();

// if ($result->num_rows > 0) {
//     while ($row = $result->fetch_assoc()) {
//         $locations[] = $row;
//     }
// }

//  ===================================================for database connection for search engine================================================

if ($db->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// $sql = "SELECT plot_data.FinalPlotNumber, owners_data.Owners, plot_data.TotalFinalPlotArea, plot_data.tenure, plot_data.OwnershipRights
$sql = "SELECT plot_data.FinalPlotNumber, owners_data.Owners, plot_data.TotalFinalPlotArea, plot_data.tenure, plot_data.OwnershipRights, owners_data.FinalPlotArea
 FROM plot_data 
 JOIN owners_data
  ON plot_data.FinalPlotNumber = owners_data.FinalPlotNumber ;
--   LIMIT 0, 25";

$result = $db->query($sql);

$data = array();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
}

// echo json_encode($data);
// $conn->close();
//  ===================================================for database connection for search engine================================================
// databasse coonect for table


// // Get table columns dynamically
// $tableName = "plot_data";
// $columnsQuery = "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = '$tableName'";
// $columnsResult = $db->query($columnsQuery);

// // SQL query to retrieve data
// $dataQuery = "SELECT * FROM $tableName";
// $dataResult = $db->query($dataQuery);

// postgresssssssssssssssssss



// Create connection
$conn = pg_connect("host =database-1.c01x1jtcm1ms.ap-south-1.rds.amazonaws.com port = 5432 dbname = pmcdb user = postgres password = anup12345");

// Check connection
if (!$conn) {
    die("Connection failed: " . pg_last_error());
}

$tableName = "Man_Final";
$columnsQuery = "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = '$tableName' 
AND COLUMN_NAME NOT IN ('fid', 'geom','Shape_Leng')";
$columnsResult = pg_query($conn, $columnsQuery);

if (!$columnsResult) {
    die("Error fetching columns: " . pg_last_error($conn));
}


// $dataQuery = "SELECT * FROM \"Man_Final\"";
// $dataResult = pg_query($conn, $dataQuery);


// $dataQuery = 'SELECT COLUMN_NAME FROM "Man_Final" AND COLUMN_NAME NOT IN ("fid", "geom")';
// $dataResult = pg_query($conn, $cdataQuery);
$dataQuery = 'SELECT "OBJECTID", "Area_Ha", "Area_acre", "Length_m","Area_Sq_m","Village","Old_Gut","TALUKA","Broad_LU","Label_name","Landuse","Plot_no" FROM "Man_Final"';
$dataResult = pg_query($conn, $dataQuery);


?>









<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>GeoPulse</title>
    <!-- <link rel="icon" type="image/x-icon" href="images/logo1.png"> -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.0/html2canvas.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.5.3/jspdf.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/leaflet@1.7.1/dist/leaflet.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/leaflet@1.7.1/dist/leaflet.css">


    <!-- BOOTSTRAP only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous">
    </script>

    <!-- jquery -->
    <script src="libs/jquery.js"></script>
    <link rel="stylesheet" href="libs/jquery-ui-1.12.1/jquery-ui.css">
    <script src="libs/jquery-ui-1.12.1/external/jquery/jquery.js"></script>
    <script src="libs/jquery-ui-1.12.1/jquery-ui.js"></script>
<!-- qrcode -->
    <script src="https://cdn.jsdelivr.net/gh/davidshimjs/qrcodejs/qrcode.min.js"></script>

    <!-- Leaflet -->

    <link rel="stylesheet" href="libs/leaflet/leaflet.css" />
    <script src="libs/leaflet/leaflet.js"></script>

    <!-- ZoomBar & slider-->
    <script src="libs/L.Control.ZoomBar-master/src/L.Control.ZoomBar.js"></script>
    <link rel="stylesheet" href="libs/L.Control.ZoomBar-master/src/L.Control.ZoomBar.css" />
    <script src="libs/Leaflet.zoomslider-master/src/L.Control.Zoomslider.js"></script>
    <link rel="stylesheet" href="libs/Leaflet.zoomslider-master/src/L.Control.Zoomslider.css" />

    <!-- MousePosition -->
    <script src="libs/Leaflet.MousePosition-master/src/L.Control.MousePosition.js"></script>
    <link rel="stylesheet" href="libs/Leaflet.MousePosition-master/src/L.Control.MousePosition.css" />

    <!-- line-measure -->
    <link rel="stylesheet" href="libs/polyline-measure/line-measure.css" />
    <script src="libs/polyline-measure/line-measure.js"></script>
    <link rel="stylesheet" href="libs/leaflet-measure-master/leaflet-measure.css" />
    <script src="libs/leaflet-measure-master/leaflet-measure.js"></script>
    <script src="libs/feat.js"></script>


    <!-- draw -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet.draw/0.4.2/leaflet.draw.css" />
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet.draw/0.4.2/leaflet.draw.js"></script> -->

    <!-- 
  <link rel="stylesheet" href="libs/leaflet-draw-control.css"> -->
    <script src="libs/leaflet-draw-control.js"></script>


    <!-- github -->
    <script src="https://kartena.github.io/Proj4Leaflet/lib/proj4-compressed.js"></script>
    <script src="https://kartena.github.io/Proj4Leaflet/src/proj4leaflet.js"></script>



    <!-- legend -->

    <link rel="stylesheet" href="libs/leaflet-wms-legend/leaflet.wmslegend.css" />
    <script src="libs/leaflet-wms-legend/leaflet.wmslegend.js"></script>


    <!-- csslink -->
    <link rel="stylesheet" href="mystyle1.css">


    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

    <!-- html2pdfcdn -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"
        integrity="sha512-GsLlZN/3F2ErC5ifS5QtgpiJtWd43JWSuIgh7mbzZ8zBps+dvLusV+eNQATqgA/HdeKFVgA5v3S/cIrLF7QnIg=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.0/jspdf.umd.min.js"></script> -->

    <script src="libs/leaflet-image.js"></script>
    <script src="https://html2canvas.hertzen.com/dist/html2canvas.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.3.1/jspdf.umd.min.js"></script>

    <!-- fontawsome -->
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

  <!-- QRcode -->
  <script src="https://cdn.rawgit.com/davidshimjs/qrcodejs/gh-pages/qrcode.min.js"></script>

    <!-- json -->


    <!--Bookmarks-->

    <!-- <script src="libs/bookmark.js"></script> -->
    <!-- <link href="libs/leaflet.bookmark.css" rel="stylesheet"> -->

    <style>
    /* CSS Styles for the Location Table */
    #ui-id-1{
        height: 70vh;
        width:25%;
        overflow-y:scroll;
    }
    #locationTable {
        width: 100%;
        border-collapse: collapse;
        color: #333;
        border: none;
        /* Font color for table elements */
    }

    /* #locationTable th, */
    #locationTable td a {
        padding: 2px;
        text-align: left;
        font-size: 12px;
        /* border-bottom: 1px solid #ddd; */

    }

    #locationTable td a:hover {
        color: greenyellow;

    }

   
    #locationTable a {
        color: whitesmoke;
        /* Font color for links */
        text-decoration: none;
    }

    .deleteBtn {
        padding: 5px 10px;
        /* background-color: #dc3545; */
        background: transparent;
        color: #fff;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        margin-left: 20px;
    }

    .deleteBtn:hover {
       color: #c82333;
    }
    
    .table-wrapper {
        width: 200px;
    max-height: 200px; /* Adjust the desired height as needed */
    overflow-y: auto;
}

    .my-custom-class {
        padding: 5px;
        font-size: 10px;
    }

    .my-success-popup-class {
        padding: 10px;
        font-size: 8px;
    }
    .my-custom-class1 {
        padding: 2px;
        font-size: 10px;
    }

    .my-success-popup-class1{
        padding: 5px;
        font-size: 8px;
    }

    .my-title-class{
            padding-top: 10px;
            font-weight: bold;
            font-size: 15px;
            color: #004aad;
        }

 /* table  */
 .content-container {
            width: 100%;
            padding:0 10%;
            
        }
 .table-container {
            background-color:white;
            box-shadow: 10px 10px 8px rgba(0, 0, 0, 0.1);
    
            max-width: 100%;
            max-height: 500px; /* Set a fixed height for the container */
            overflow-y: auto; /* Enable vertical scrolling */
        }
        table {
           
            width: 100%; /* Make the table fill the container */
            border-collapse: collapse;
        }
        th {
            
            background-color: #2980b9; /* Header background color */
            color: #ffffff; /* Header text color */
            cursor: pointer;
            height: 40px; 
            position: sticky;
            top: 0;
            z-index: 1;
        }
        th:hover {
            background-color: #3498db; /* Header background color on hover */
        }

    </style>
</head>

<body class="overflow-hidden">
    <div id="wrapper">

        <aside id="sidebar-wrapper">
            <div class="sidebar-brand">
                <h2 style="color:#dddddd">
                
                    GeoPulse</h2>
            </div>
            <ul class="sidebar-nav">
                <li class="active">
                    <h3 class="profile-username  fw-bold text-capitalize fs-5 px-4 pt-4 " style="color:#dddddd;">
                        <?php
                        echo $_SESSION['username'];
                        ?>
                    </h3>

                    <p class="text-muted px-4 ">
                        <?php
                        echo $user['email'];
                        ?>
                    </p>

                </li>



                <li>
                    <!-- <div class=""> -->
                        <a class="fs-6 px-3 "style="color:#dddddd;"  href="index.php"><i class="fa-solid fa-house"></i>   Dashboard</a>
                    <!-- </div> -->
                </li>

                <li>
                    <!-- <div class=""> -->
                        <a class="fs-6 px-3 " style="color:#dddddd;" href="chart.php"><i class="fas fa-chart-line"></i>   Statistics </a>
                    <!-- </div> -->
                </li>

                <!-- <hr class="text-light mx-3"> -->
                    <!-- *************************prompt ************** -->

               



                <li class="nav-item">

                </li>
            </ul>
        </aside>

        <div id="navbar-wrapper">
            <nav class="navbar navbar-inverse">
                <div class="container-fluid">
                    <div class="navbar-header">

                        <a href="#" class="navbar-brand fs-3" id="sidebar-toggle" onclick="toggleSidebar()">
                            <i id="sidebar-open-icon" class="fas fa-angle-double-left"
                                style=" padding :10px; border-radius:180%;  color: #343a40;"></i>
                            <i id="sidebar-close-icon" class="fas fa-angle-double-right d-none"
                                style=" color: #343a40;"></i>
                        </a>
                    </div>
                    <form action="Logout.php" method="post">
                        <button class="tablinks bg-danger text-light p-1 px-2"
                            style="border:0; font-size:15px ; border-radius:10px;" name="Logout" type="submit"><img
                                src="images/logout2.jpg" alt="image not found" style=" width:20px; height:20px;"><span
                                class="d-none d-sm-inline"> logout</span>
                        </button>
                    </form>
                </div>
            </nav>
        </div>

        <section id="content-wrapper">
            <!-- <div>
            <h4 class="fw-bold  p-4"  style="color:#2980b9;">Charts:</h4>


            </div>
                <hr> -->
            <div>
                <h4 class="fw-bold  p-4" style="color:#2980b9;">Plot No. Details</h4>
                                            <div class="content-container">
                                
                                            <div class="table-container">
                                <table border="1">
                                    <tr>
                                        <?php
                                        // Output column names dynamically
                                        while ($column = pg_fetch_assoc($columnsResult)) {
                                            $columnName = $column['column_name'];
                                            echo "<th onclick='sortTable(\"$columnName\")'>$columnName</th>";
                                        }
                                        ?>
                                    </tr>

                                    <?php
                                    // Output data from rows if $dataResult is valid
                                    if ($dataResult) {
                                        while ($row = pg_fetch_assoc($dataResult)) {
                                            echo "<tr>";
                                            foreach ($row as $value) {
                                                echo "<td>" . $value . "</td>";
                                            }
                                            echo "</tr>";
                                        }
                                    } else {
                                        echo "<tr><td colspan='100%'>No data available</td></tr>";
                                    }
                                    ?>
                                </table>
                            </div>



                                    </div>

  
            </div>
               
        </section>


    </div>

<script>


    const $button = document.querySelector('#sidebar-toggle');
    const $wrapper = document.querySelector('#wrapper');

    $button.addEventListener('click', (e) => {
        e.preventDefault();
        $wrapper.classList.toggle('toggled');
    });

    function toggleSidebar() {
        var sidebar = document.getElementById("sidebar-wrapper");
        var openIcon = document.getElementById("sidebar-open-icon");
        var closeIcon = document.getElementById("sidebar-close-icon");

        if (sidebar.classList.contains("toggled")) {
            // Sidebar is open, so close it
            sidebar.classList.remove("toggled");
            openIcon.classList.remove("d-none");
            closeIcon.classList.add("d-none");
        } else {
            // Sidebar is closed, so open it
            sidebar.classList.add("toggled");
            openIcon.classList.add("d-none");
            closeIcon.classList.remove("d-none");
        }
    }
   



    </script>

</body>

</html>