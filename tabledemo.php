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




// Create connection
$conn = new PDO("pgsql:host =database-1.c01x1jtcm1ms.ap-south-1.rds.amazonaws.com port = 5432 dbname = geopulse1 user = postgres password = anup12345");

// Check connection
if (!$conn) {
    die("Connection failed: " . pg_last_error());
}
// $tableName = "plu_data";

// $tableName = "Man_Final";
$columnsQuery = $conn->prepare("SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = '$tableName' 
AND COLUMN_NAME NOT IN ('fid', 'geom','Shape_Leng')");
$columnsQuery-> execute();
// echo $columnsQuery;
if (!$columnsQuery) {
    die("Error fetching columns: " . pg_last_error($conn));
}
$columns = $columnsQuery->fetchAll(PDO::FETCH_COLUMN);

// Construct a comma-separated string of column names
$columnNames = implode(', ', array_map(function($column) {
    return "\"$column\"";
}, $columns));
// Fetch rows using the specified columns
// $rowsQuery = $conn->prepare("SELECT $columnNames FROM \"Man_Final\"");
$limit = 10000; // Change this to the number of rows you want to retrieve

$rowsQuery = $conn->prepare("SELECT $columnNames FROM \"plu_data\" LIMIT :limit");
$rowsQuery->bindParam(':limit', $limit, PDO::PARAM_INT);
$rowsQuery->execute();
$rows = $rowsQuery->fetchAll(PDO::FETCH_ASSOC);


// Close the cursor to free up resources
// $rowsQuery->closeCursor();
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

   

    <!-- github -->
    <script src="https://kartena.github.io/Proj4Leaflet/lib/proj4-compressed.js"></script>
    <script src="https://kartena.github.io/Proj4Leaflet/src/proj4leaflet.js"></script>



    <!-- csslink -->
    <link rel="stylesheet" href="mystyle1.css">




    <!-- fontawsome -->
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />


<!-- DataTables CSS -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">

<!-- DataTables JS -->
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<!-- jQuery UI Autocomplete CSS -->
<link rel="stylesheet" type="text/css" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

<!-- jQuery UI Autocomplete JS -->
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<!-- DataTables Column Filter CSS -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/colreorder/1.5.4/css/colReorder.dataTables.min.css">

<!-- DataTables Column Filter JS -->
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/colreorder/1.5.4/js/dataTables.colReorder.min.js"></script>


    <style>
    /* CSS Styles for the Location Table */
    #ui-id-1{
        height: 70vh;
        width:25%;
        overflow-y:scroll;
    }

 /* table  */
 .content-container {        
            width: 100%;
            padding:0 5%;
            
        }
 .table-container {
            background-color:white;
            box-shadow: 10px 10px 8px rgba(0, 0, 0, 0.1);
    
            max-width: 100%;
            max-height: 78vh; /* Set a fixed height for the container */
            overflow-y: auto; /* Enable vertical scrolling */
        }
        table {
           
            width: 100%; /* Make the table fill the container */
            border-collapse: collapse;
        }

        
        thead {
            
            background-color: #343a40; /* Header background color */
            color: #ffffff; /* Header text color */
            cursor: pointer;
            height: 40px; 
            position: sticky;
            top: 0;
            z-index: 1;
        }
        thead:hover {
            background-color: #343a4070; /* Header background color on hover */
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
          
            <div>
                <h4 class="fw-bold  p-4" style="color:#343a40;">Plot No. Details</h4>
                                            <div class="content-container">
                                
                                            <div class="table-container p-3">
                                          
                                          
                                            <table class="dataTable p-3 "id="myDataTable" border="1">
                            <thead>
                                <tr>
                                    <?php
                                    // Output table header with column names
                                    foreach ($columns as $column) {
                                        echo "<th>$column</th>";
                                        // echo "</tr>";
                                    }                   ?>
                                </tr>
                               
                            </thead> 

                                    <tbody>
                                    <?php
                                        // Output table rows with data
                                        foreach ($rows as $row) {
                                            echo "<tr>";
                                            foreach ($row as $value) {
                                                echo "<td>$value</td>";
                                            }
                                            echo "</tr>";
        }
                                    ?>          
                            </tbody>
                         

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
   
///datatable.............
    // $(document).ready(function () {
    //         var table = $('.dataTable').DataTable();

    //         $('.columnFilter').on('input', function () {
    //             var column = $(this).data('column');
    //             table.column(column).search($(this).val()).draw();
    //         });

    //     })
    $(document).ready(function () {
    // var table = $('.dataTable').DataTable({
    //     colReorder: true, // Enable the Column Reorder extension
    //     dom: 'Rlfrtip', // Include the Column Reorder tools
    //     initComplete: function () {
    //         // Initialize the column filters
    //         this.api().columns().every(function () {
    //             var column = this;
    //             var select = $('<select><option value=""></option></select>')
    //                 .appendTo($(column.header()))
    //                 .on('change', function () {
    //                     var val = $.fn.dataTable.util.escapeRegex(
    //                         $(this).val()
    //                     );
    //                     column.search(val ? '^' + val + '$' : '', true, false).draw();
    //                 });

    //             column.data().unique().sort().each(function (d, j) {
    //                 select.append('<option value="' + d + '">' + d + '</option>');
    //             });
    //         });
    //     }
    // });

    var table = $('#myDataTable').DataTable({
        colReorder: true, // Enable the Column Reorder extension
        dom: 'Rlfrtip', // Include the Column Reorder tools
        lengthMenu: [ [10, 25, 50, 100, -1], [10, 25, 50, 100, "All"] ], // Set the display length options
        pageLength: 10, // Set the default display length

        initComplete: function () {
            // Initialize the column filters
            this.api().columns().every(function () {
                var column = this;
                var select = $('<select><option value=""></option></select>')
                    .appendTo($(column.header()))
                    .on('change', function () {
                        var val = $.fn.dataTable.util.escapeRegex(
                            $(this).val()
                        );
                        column.search(val ? '^' + val + '$' : '', true, false).draw();
                    });

                column.data().unique().sort().each(function (d, j) {
                    select.append('<option value="' + d + '">' + d + '</option>');
                });
            });
        }
    });


    // Handle input change for individual column filtering
    $('.columnFilter').on('input', function () {
        var column = $(this).data('column');
        table.column(column).search($(this).val()).draw();
    });
});



    </script>





</body>

</html>