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
$sql = "SELECT * FROM locations  WHERE username = '$username'";
$result = $db->query($sql);

$locations = array();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $locations[] = $row;
    }
}


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

    <!-- json -->

    <script>
    $(function() {
        var availableTags = ['113-B', '12 m', '12 m', '15 m', '18 m', '186', '187', '188', '189', '190', '191', '192', '193', '194', '195', '196', '197-A', '197-B', '198', '199', '200', '201', "201-A", '202-A','203', '204', '204-A', '205', '206', '208', '209', '210', '211', '212', '213-A', '213-B', '213-C', '213-D', '214', '214-A', '215', '216', '217', '219', '220', '221', '222', '223', '224', '225', '228', '229', '230-A', '230-B', '231', '233', '234-A', '234-B', '235', '236', '236', '237-A', '237-B', '238', '239', '240', '241', '242', '243', '244', '245', '246', '247', '248', '248-A', '249', '249-A', '250', '250-A', '250-B', '251', '252-A', '252-B', '252-C', '253-A', '253-B', '254', '255', '256', '257', '258', '259', '260', '261-A', '261-B', '262', '263-A', '264', '265', '266', '267', '268', '269', '269-A', '271', '272', '272', '272-A', '274', '274', '275-A', '275-B', '275-C', '276', '277', '278-B', '281', '281-A', '284', '287', '288', '291', '292', '293', '294', '296', '297', '298', '299', '3', '30 m', '30 m', '300', '301', '302', '303', '304', '306', '307', '308', '313-B', '313-C', '319', '333', '334', '335', '336', '337', '338', '339', '340', '341', '342', '342-A', '345', '346', '347-A', '347-B', '349', '351', '352-A', '352-B', '354', '355', '356-A', '357', '358', '359', '36 m', '36 m', '360', '363', '364', '365', '366', '367', '368', '368-A', '369', '370', '371', '374', '378-A', '379', '379-A', '385-B', '386', '386-A', '388', '397', '398 B.S-6', '404', '407', 'EWS/LIG/DP-13', 'EWS/LIG/DP-14'

        ];
        $(".search").autocomplete({
            source: availableTags
        });
    });
    </script>


    <!--Bookmarks-->

    <!-- <script src="libs/bookmark.js"></script> -->
    <!-- <link href="libs/leaflet.bookmark.css" rel="stylesheet"> -->

    <style>
    /* CSS Styles for the Location Table */

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
    </style>
</head>

<body>
    <div id="wrapper">

        <aside id="sidebar-wrapper">
            <div class="sidebar-brand">
                <h2 style="color:#dddddd">
                <!-- <img class="imglogo" src="images/logo1.png" alt="image not found"
                        style="width:40px; height:40px; border-radius:180%; background-color:#dddddd; margin-top:-3%;"> -->
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
                    <!-- *************************prompt ************** -->

                

                    <div class="dropdown">
                        <button class="btn btn-outline-secondary dropdown-toggle  text-light ms-1 " type="button"
                            id="locationDropdown" data-bs-toggle="dropdown" aria-expanded="false"> <i
                                class="fad fa-bookmark"></i>
                            Bookmarks
                        </button>
                        <ul class="dropdown-menu ms-1 px-2 bg-transparent" aria-labelledby="locationDropdown" >
                            <p type="button" class="text-light" style="font-size:12px;" id="saveBtn">Create Bookmark <i
                                    class="far fa-plus-circle"></i>
                            </p>
                            <div class="table-wrapper">
                                <table id="locationTable">
                                    <tbody></tbody>
                                    
                                    
                                </table>
                            </div>
                        </ul>
                    </div>


                </li>

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
            <div id="map"></div>

            <div id="main">
                <!-- <img src="images/logo1.png" alt="image not found"> -->
                <div class="main_search">
                    <input type="text" placeholder="Search.." name="search2" class="search">

                    <button class="bg-light" id="btnData2" type="button" onclick="SearchMe(); sendData()"><i
                            class="far fa-search"></i></button>

                    <button class="btn-success" id="btnData1" type="button" onclick="ClearMe()">Clear</button>


                    <button onclick="takeScreenshot()" id="save-btn" class="text-light border-0 "
                        style="background:#004aad;    "><i class="fas fa-download"></i></button>
                    <!-- <button >Export Map</button> -->

                </div>
                <!-- <i class="fad fa-user fs-3 " ></i>
    <p class="username" onclick="openNav()">
        <?php echo $_SESSION['username']; ?>
    </p> -->

            </div>
        </section>


    </div>



    <!-- *********************************************MAP.JS******************************************************************************************* -->








    <script>
    // MAP
    
// ==================================================
// MAP
var map, geojson;

//Add Basemap
// var map = L.map("map", {}).setView([18.5712, 73.7332], 17, L.CRS.EPSG4326);
var map = L.map("map", {}).setView([18.5690, 73.7432], 16, L.CRS.EPSG4326);


var osm = L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
  attribution:
    '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
});

var googleSat = L.tileLayer(
  "http://{s}.google.com/vt/lyrs=s&x={x}&y={y}&z={z}",
  {
    maxZoom: 35,
    subdomains: ["mt0", "mt1", "mt2", "mt3"]
  }
);


var Esri_WorldImagery = L.tileLayer(
  "https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}",
  {
    attribution:
      "Tiles &copy; Esri &mdash; Source: Esri, i-cubed, USDA, USGS, AEX, GeoEye, Getmapping, Aerogrid, IGN, IGP, UPR-EGP, and the GIS User Community"
  }
);
<!-- -----------------layer displayed------------------------ -->
var baseLayers = {
//   OSM: osm,
//   ESRI: Esri_WorldImagery,
//   GoogleImage: googleSat,
  
};

var wms_layer = L.tileLayer.wms(
  "https://portal.geopulsea.com/geoserver/Man/wfs",
  {
    layers: "Man:Man_TPS",
    format: "image/png",
    transparent: true,
    version: "1.1.0",
    attribution: "Man_TPS",
    maxZoom: "28",
  }
);
var wms_layer1 = L.tileLayer.wms(
  "https://portal.geopulsea.com/geoserver/Man/wfs",
  {
    layers: "Man:Man_TPS",
    format: "image/png",
    transparent: true,
    version: "1.1.0",
    attribution: "Man_TPS",
    maxZoom: "28",
  }
);


// osm.addTo(map)
wms_layer.addTo(map)



// // osm.addTo(map)
// wms_layer.addTo(map)



var WMSlayers = {
  
  
  OSM: osm,
  ESRI: Esri_WorldImagery,
  GoogleImage: googleSat,
  
  
  Man: wms_layer,


};
var control = new L.control.layers(baseLayers, WMSlayers).addTo(map);



    map.on("contextmenu", (e) => {
        let size = map.getSize();
        let bbox = map.getBounds().toBBoxString();
        let layer = 'Man:Man_TPS';
        let style = 'Man:Man_TPS';
        let urrr =
            `https://portal.geopulsea.com/geoserver/Man/wms?SERVICE=WMS&VERSION=1.1.1&REQUEST=GetFeatureInfo&FORMAT=image%2Fpng&TRANSPARENT=true&QUERY_LAYERS=${layer}&STYLES&LAYERS=${layer}&exceptions=application%2Fvnd.ogc.se_inimage&INFO_FORMAT=application/json&FEATURE_COUNT=50&X=${Math.round(e.containerPoint.x)}&Y=${Math.round(e.containerPoint.y)}&SRS=EPSG%3A4326&WIDTH=${size.x}&HEIGHT=${size.y}&BBOX=${bbox}`

        // you can use this url for further processing such as fetching data from server or showing it on the map

        if (urrr) {
            fetch(urrr)

                .then((response) => response.json())
                .then((html) => {

                    var htmldata = html.features[0].properties
                    let keys = Object.keys(htmldata);
                    let values = Object.values(htmldata);
                    let txtk1 = "";
                    var xx = 0
                    for (let gb in keys) {
                        txtk1 += "<tr><td>" + keys[xx] + "</td><td>" + values[xx] + "</td></tr>";
                        xx += 1
                    };
                    let detaildata1 =
                        "<div style='max-height: 350px; width:100%;  overflow-y: scroll;'><table  style='width:100%;' class='popup-table' >" +
                        txtk1 + "<tr><td>Co-Ordinates</td><td>" + e.latlng +
                        "</td></tr></table></div>"

                    L.popup()
                        .setLatLng(e.latlng)
                        .setContent(detaildata1)
                        .openOn(map);
                })
        }
    });



    map.on('dblclick', function(e) {
        var lat = e.latlng.lat.toFixed(15);
        var lng = e.latlng.lng.toFixed(15);
        // console.log(lat, lng)
        var popupContent = '<a href="https://earth.google.com/web/search/' + lat + "," + lng +
            '" target="_blank">Open in Google Earth</a><br>' +
    'Latitude: ' + lat + ' <br> ' +
    'Longitude: ' + lng + '<hr>' +
     + lat + ' , ' 
     + lng;
        L.popup()
            .setLatLng(e.latlng)
            .setContent(popupContent)
            .openOn(map);
    });

    // var control = new L.control.layers(baseLayers, WMSlayers).addTo(map);






    // ***************************************************************Draw control***************************************************************
    var polyline = L.polyline([], {
        color: 'red'
    });
    var polygon = L.polygon([], {
        color: 'red'
    });
    var circle = L.circle([], {
        color: 'red'
    });
    var coordinates = [];

    var editableLayers = new L.FeatureGroup(); // add the polyline to the FeatureGroup
    map.addLayer(editableLayers);

    var drawPluginOptions = {
        position: 'topright',
        draw: {
            polygon: {
                allowIntersection: true, // Restricts shapes to simple polygons
                shapeOptions: {
                    dashArray: '2, 5',
                    color: 'red'

                }
            },

            polyline: {
                allowIntersection: true, // Restricts shapes to simple polylines
                shapeOptions: {
                    dashArray: '2, 5',
                    color: 'red'
                }
            },

            circle: {
                allowIntersection: true, // Restricts shapes to simple polylines
                shapeOptions: {
                    dashArray: '2, 5',
                    color: "red",


                }
            },
            // disable toolbar item by setting it to false
            // Turns off this drawing tool
            rectangle: false,
            marker: false,
        },
        edit: {
            featureGroup: editableLayers, //REQUIRED!!
            remove: true
        }
    };

    //****************** */ Initialise the draw control and pass it the FeatureGroup of editable layers*************************
    var drawControl = new L.Control.Draw(drawPluginOptions);
    map.addControl(drawControl);

    map.on('draw:created', function(e) {
        var type = e.layerType;
        var layer = e.layer;

        if (type === 'polyline') {
            // add the drawn polyline to the FeatureGroup
            editableLayers.addLayer(layer);

            // update the coordinates variable
            var latlngs = layer.getLatLngs();
            coordinates = latlngs.map(function(latlng) {
                return [latlng.lat, latlng.lng];
            });
            polyline.setLatLngs(coordinates);
        } else if (type === 'polygon') {
            // add the drawn polygon to the FeatureGroup
            editableLayers.addLayer(layer);

            // update the coordinates variable
            var latlngs = layer.getLatLngs();
            coordinates = latlngs.map(function(latlng) {
                return [latlng.lat, latlng.lng];
            });
            polygon.setLatLngs(coordinates);
        } else if (type === 'circle') {
            // add the drawn polyline to the FeatureGroup
            editableLayers.addLayer(layer);

            // update the coordinates variable
            var latlngs = layer.getLatLngs();
            coordinates = latlngs.map(function(latlng) {
                return [latlng.lat, latlng.lng];
            });
            circle.setLatLngs(coordinates);
        }
    });




    // **********************************************



    // var editableLayers = new L.FeatureGroup();
    // map.addLayer(editableLayers);

    map.on('draw:created', function(e) {
        var type = e.layerType,
            layer = e.layer;

        editableLayers.addLayer(layer);
    });

    var north = L.control({
        position: "bottomleft"
    });
    north.onAdd = function(map) {
        var div = L.DomUtil.create("div", "info legend");
        div.innerHTML = '<img src="./images/North.png" style = "height: 50px; width: 50px;">';
        return div;
    }
    north.addTo(map);

    uri =
        "https://portal.geopulsea.com/geoserver/wms?REQUEST=GetLegendGraphic&VERSION=1.0.0&FORMAT=image/png&WIDTH=40&HEIGHT=28  &LAYER=Man:Man_TPS", {
            // namedToggle: false,

        };
    L.wmsLegend(uri);
    //

    // control
    // mouse position

    //******************************************************************Scale***************************************************************

    L.control
        .scale({
            imperial: false,
            maxWidth: 200,
            metric: true,
            position: 'bottomleft',
            updateWhenIdle: false
        })
        .addTo(map);

    //**************************************************line mesure*************************************************************
    L.control
        .polylineMeasure({
            position: "topleft",
            unit: "kilometres",
            showBearings: true,
            clearMeasurementsOnStop: false,
            showClearControl: true,
            showUnitControl: true
        })
        .addTo(map);

    //**********************************************************area measure**********************************************************************
    var measureControl = new L.Control.Measure({
        position: "topleft"
    });
    measureControl.addTo(map);

    $('#btnData2').click(function() {
        SearchMe();
    });

    $('#btnData1').click(function() {
        ClearMe();
    });


    // *****************************************************************Search Button**********************************************************************
    function SearchMe() {
        var array = $('.search').val().split(",");

        if (array.length == 1) {
            var sql_filter1 = "	Plot_no Like '" + array[0] + "'"
            fitbou(sql_filter1)
            console.log(fitbou,"jjjjjjjj");
            wms_layer1.setParams({
                cql_filter: sql_filter1,
                styles: 'highlight',
            });
            wms_layer1.addTo(map);
        } else {
        
        console.log("Search using plot number only. Ignoring additional parameters.");
    }
        
        // else if (array.length == 2) {
        //     var sql_filter1 = "Village__1 Like '" + array[0] + "'" + "AND Taluka Like '" + array[1] + "'"
        //     fitbou(sql_filter1)
        //     wms_layer12.setParams({
        //         cql_filter: sql_filter1,
        //         styles: 'highlight',
        //     });
        //     wms_layer12.addTo(map);
        // } else if (array.length >= 3) {
        //     var guts = array.slice(2, array.length).join(", ")
        //     var sql_filter1 = "Village__1 Like '" + array[0] + "'" + "AND Gut_Number IN (" + guts + ")" +
        //         "AND Taluka Like '" + array[1] + "'"
        //     fitbou(sql_filter1)
        //     wms_layer12.setParams({
        //         cql_filter: sql_filter1,
        //         styles: 'highlight',
        //     });
        //     wms_layer12.addTo(map);
        // }

    }
    // ------------------------------------------save search history-------
    function sendData() {
        var searchQuery = $('.search').val();
        var data = {
            query: searchQuery,
            username: "<?php echo $_SESSION['username'] ?>",
        };

        var xhr = new XMLHttpRequest();

        //👇 set the PHP page you want to send data to
        xhr.open("POST", "save_search_data.php", true);
        xhr.setRequestHeader("Content-Type", "application/json");

        //👇 what to do when you receive a response
        xhr.onreadystatechange = function() {
            if (xhr.readyState == XMLHttpRequest.DONE) {
                // alert(xhr.responseText);
            }
        };


        //👇 send the data
        xhr.send(JSON.stringify(data));
    }
    // -------------------------------------------------

    function fitbou(filter) {
        var layer = 'Man_Final'
        var urlm = "https://portal.geopulsea.com/geoserver/ows?service=WFS&version=1.0.0&request=GetFeature&typeName=" +
            layer + "&CQL_FILTER=" + filter + "&outputFormat=application/json";
        $.getJSON(urlm, function(data) {
            geojson = L.geoJson(data, { });
         
            map.fitBounds(geojson.getBounds());
        });
      console.log(urlm,"ffffffffff");
    };

    function ClearMe() {
        map.setView([18.5712, 73.7332], 17, L.CRS.EPSG4326);
    };





    // ***************************************************************Make QUery***************************************************************

    // $("#button").click(function() {
    //     $("#box form").toggle("slow");
    //     $(document).ready(function() {
    //         $.ajax({
    //             type: "GET",
    //             url: "https://portal.geopulsea.com/geoserver/Man_TPS/wfs?request=getCapabilities",
    //             dataType: "xml",
    //             success: function(xml) {
    //                 var select1 = $('#layer');

    //                 $(xml).find('FeatureType').each(function() {
    //                     $(this).find('Name').each(function() {
    //                         var value = $(this).text();
    //                         select1.append(
    //                             "<option class='ddindent' value='" +
    //                             value + "'>" + value + "</option>");
    //                     });
    //                 });
    //             }
    //         });
    //     });
    //     $(function() {
    //         $("#layer").change(function() {
    //             var attributes = document.getElementById("attributes");
    //             var length = attributes.options.length;
    //             for (i = length - 1; i >= 0; i--) {
    //                 attributes.options[i] = null;
    //             }
    //             var value_layer1 = $(this).val();
    //             $(document).ready(function() {
    //                 $.ajax({
    //                     type: "GET",
    //                     url: "https://portal.geopulsea.com/geoserver/wfs?service=WFS&request=DescribeFeatureType&version=1.1.0&typeName=" +
    //                         value_layer1,
    //                     dataType: "xml",

    //                     success: function(xml) {

    //                         var select2 = $('#attributes');
    //                         $(xml).find('xsd\\:sequence').each(function() {
    //                             $(this).find('xsd\\:element').each(
    //                                 function() {
    //                                     var value = $(this)
    //                                         .attr('name');
    //                                     var type = $(this).attr(
    //                                         'type');
    //                                     if (value != 'geom' &&
    //                                         value != 'the_geom'
    //                                     ) {
    //                                         select2.append(
    //                                             "<option class='ddindent' value='" +
    //                                             type +
    //                                             "'>" +
    //                                             value +
    //                                             "</option>");
    //                                     }
    //                                 });
    //                         });
    //                     }
    //                 })
    //             });
    //             document.getElementById("textval").innerHTML = value_layer1;
    //         })
    //     });
    //     $(function() {
    //         $("#attributes").change(function() {
    //             var operator = document.getElementById("operator");
    //             var attributes = $("#layer option:selected").text();
    //             var length = operator.options.length;
    //             for (i = length - 1; i >= 0; i--) {
    //                 operator.options[i] = null;
    //             }
    //             var value_type = $(this).val();
    //             var value_attribute = $('#attributes option:selected').text();
    //             operator.options[0] = new Option('Select operator', "");
    //             if (value_type == 'xsd:short' || value_type == 'xsd:int' || value_type ==
    //                 'xsd:double') {
    //                 var operator1 = document.getElementById("operator");
    //                 operator1.options[1] = new Option('>', '>');
    //                 operator1.options[2] = new Option('<', '<');
    //                 operator1.options[3] = new Option('=', '=');
    //                 operator1.options[4] = new Option('<=', '<=');
    //                 operator1.options[5] = new Option('=>', '=>');
    //                 operator1.options[6] = new Option('IN ()', 'IN');
    //                 operator1.options[7] = new Option('OR ||', 'OR');
    //                 operator1.options[8] = new Option('AND &', 'AND');
    //             } else if (value_type == 'xsd:string') {
    //                 var operator1 = document.getElementById("operator");
    //                 operator1.options[1] = new Option('Like', 'ILike');
    //                 operator1.options[2] = new Option('IN ()', 'IN');
    //                 operator1.options[3] = new Option('OR ||', 'OR');
    //                 operator1.options[4] = new Option('AND &', 'AND');
    //             }


    //             var selectvalue = document.getElementById("selectvalue");
    //             var length = selectvalue.options.length;
    //             for (i = length - 1; i >= 0; i--) {
    //                 selectvalue.options[i] = null;
    //             }

    //             $(document).ready(function() {
    //                 $.ajax({
    //                     type: "GET",
    //                     url: "https://portal.geopulsea.com/geoserver/wfs?service=wfs&version=1.0.0&request=getfeature&typename=" +
    //                         attributes + "&PROPERTYNAME=" + value_attribute,
    //                     dataType: "xml",
    //                     success: function(xml) {
    //                         var select3 = $('#selectvalue');
    //                         var unq = new Array();
    //                         $(xml).each(function() {
    //                             $(this).find('gml\\:featureMember')
    //                                 .each(function() {
    //                                     unq.push($(this)
    //                                         .text());
    //                                 });
    //                             let unique = unq.filter((item, i,
    //                                 ar) => ar.indexOf(
    //                                 item) === i);
    //                             for (let i = 0; i < unique
    //                                 .length; i++) {
    //                                 select3.append(
    //                                     "<option class='ddindent' value='" +
    //                                     unique[i] + "'>" +
    //                                     unique[i] + "</option>");
    //                             }
    //                         });
    //                     }
    //                 });
    //             });
    //             document.getElementById("textval").innerHTML = "From Layer" + attributes +
    //                 " is " + value_attribute;
    //         });

    //     });
    // });



    // $(function() {
    //     $("#selectvalue").change(function() {
    //         var vars = ['layer', 'attributes', 'operator', 'selectvalue'];
    //         for (let i = 0; i < vars.length; i++) {
    //             //   var operator = document.getElementById("operator");
    //             var layer = $("#layer option:selected").text();
    //             var attributes = $("#attributes option:selected").text();
    //             var operator = $("#operator option:selected").text();
    //             var selectvalue = $("#selectvalue option:selected").text();
    //         }
    //         document.getElementById("textval").innerHTML = "From Layer " + layer + " column is " +
    //             attributes + " " + operator + " value is " + selectvalue;

    //         var sql_filter1 = attributes + " Like '" + selectvalue + "'"
    //         // console.log(sql_filter1)
    //         fitbou(sql_filter1, layer)

    //         var wms_layerf = L.tileLayer.wms(
    //             "https://portal.geopulsea.com/geoserver/Man_TPS/wms", {
    //                 layers: layer,
    //                 format: "image/png",
    //                 transparent: true,
    //                 tiled: true,
    //                 version: "1.1.0",
    //                 attribution: "ugc",
    //                 opacity: 1,
    //                 cql_filter: sql_filter1,
    //                 styles: 'highlight',

    //             }
    //         );
    //         wms_layerf.addTo(map);


    //         function fitbou(filter, layer1) {
    //             var urlm =
    //                 "https://portal.geopulsea.com/geoserver/ows?service=WFS&version=1.0.0&request=GetFeature&typeName=" +
    //                 layer1 + "&CQL_FILTER=" + filter + "&outputFormat=application/json";
    //             // console.log(urlm)
    //             $.getJSON(urlm, function(data) {
    //                 geojson = L.geoJson(data, {});
    //                 map.fitBounds(geojson.getBounds());
    //             });
    //         };


    //     });
    // })






    // ***************************************************pdf*********************************************************

    function takeScreenshot() {
        html2canvas(document.getElementById('map'), {
            useCORS: true
        }).then(function(canvas) {
            var imgData = canvas.toDataURL('image/png');

            var pdf = new jsPDF();
            pdf.addImage(imgData, 'PNG', 15, 25, 180, 105); //x,y , width, height
               // Calculate the dimensions for the selected part
        var selectedPartWidth = geojsonBounds.getEast() - geojsonBounds.getWest();
        var selectedPartHeight = geojsonBounds.getNorth() - geojsonBounds.getSouth();

        // Add the selected part to the PDF
        pdf.addImage(imgData, 'PNG', 15, 170, selectedPartWidth, selectedPartHeight);

            // Get the height of the canvas element and add it to the PDF
            var imgHeight = canvas.height;

            // Add the local image to the PDF
            var img = new Image();
            img.onload = function() {
                pdf.addImage(img, 'PNG', 15, 170, 180, 80);
                pdf.save('map.pdf');
            };
            img.src = 'finalLegend.png';
        });
    }




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
   

    // --------------------------------------bookmark updated code
    $('#saveBtn').on('click', function() {
  var userN = "<?php echo $_SESSION['username'] ?>";
  
  // Get the center coordinates of the map
  var mapCenter = map.getCenter();
  var latitude = mapCenter.lat;
  var longitude = mapCenter.lng;

  // Show a SweetAlert dialog with an input field for the location name
  Swal.fire({
    title: 'Save Location',
    html: '<input id="locationName" class="swal2-input" placeholder="Enter location name">',
    showCancelButton: true,
    confirmButtonText: 'Save',
    preConfirm: function() {
      var name = Swal.getPopup().querySelector('#locationName').value;
      return name;
    },
    customClass: {
      popup: 'my-custom-class',
      title: 'my-title-class'
    }
  }).then(function(result) {
    var name = result.value;
    
    if (name) {
      $.ajax({
        type: 'POST',
        url: 'bkmrk/save_location.php',
        data: {
          userN: userN,
          lat: latitude,
          lng: longitude,
          name: name
        },
        success: function(response) {
          Swal.fire({
            title: 'Location saved successfully.',
            icon: 'success',
            customClass: {
              popup: 'my-success-popup-class',
              title: 'my-title-class'
            }
          });
          // Reload table
          loadLocationTable();
        },
        error: function(xhr, status, error) {
          console.log(xhr.responseText);
          Swal.fire({
            title: 'An error occurred while saving the location.',
            customClass: {
              popup: 'my-success-popup-class',
              title: 'my-title-class'
            }
        });
        }
      });
    }
  });
});



    function loadLocationTable() {
        var userN = "<?php echo $_SESSION['username'] ?>";
        $.ajax({
            type: 'GET',
            url: 'bkmrk/get_locations.php',
            dataType: 'json',
            success: function(response) {
                var locations = response;
                var tableBody = $('#locationTable tbody');
                tableBody.empty();

                for (var i = 0; i < locations.length; i++) {
                    var location = locations[i];
                    var row = '<tr>' +
                        '<td><a href="#" onclick="zoomToLocation(' + location.latitude + ', ' + location
                        .longitude + ')">' + location.name + '</a></td>' +
                        '<td><button class="deleteBtn" data-id="' + location.id +
                        '"><i class="fas fa-trash-alt"></i></button></td>' +
                        '</tr>';
                    tableBody.append(row);
                }
            },
            error: function(xhr, status, error) {
                console.log(xhr.responseText);
                alert('An error occurred while retrieving locations.');
            }
        });
    }

    $(document).on('click', '.deleteBtn', function() {
  var locationId = $(this).data('id');

  // Show a confirmation dialog before deleting
  Swal.fire({
    title: 'Delete Bookmark',
    text: 'Are you sure you want to delete this bookmark?',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonText: 'Delete',
    cancelButtonText: 'Cancel',
    customClass: {
      popup: 'my-custom-class',
      title: 'my-title-class'
    }
  }).then(function(result) {
    if (result.isConfirmed) {
      // User confirmed the deletion, proceed with AJAX request
      $.ajax({
        type: 'POST',
        url: 'bkmrk/delete_location.php',
        data: {
          id: locationId
        },
        success: function(response) {
          Swal.fire({
            title: 'Bookmark deleted successfully.',
            position: 'center',
            icon: 'success',
            customClass: {
              popup: 'my-custom-class1',
              title: 'my-title-class'
            }
          });
          // Reload table
          loadLocationTable();
        },
        error: function(xhr, status, error) {
          console.log(xhr.responseText);
          Swal.fire({
            title: 'An error occurred while deleting the location.',
            position: 'center',
            icon: 'error',
            customClass: {
              popup: 'my-success-popup-class1',
              title: 'my-title-class'
            }
          });
        }
      });
    }
  });
});



    function zoomToLocation(latitude, longitude) {
        map.flyTo([latitude, longitude], 15);
    }
    // Load table on page load
    loadLocationTable();

    </script>

</body>

</html>