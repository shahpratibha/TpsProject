<!DOCTYPE html>
<html>

<head>
    <title>Save Location</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <style>
        #map {
            height: 400px;
        }

        #locationTable {
            margin-top: 20px;
            border-collapse: collapse;
        }

        #locationTable th,
        #locationTable td {
            padding: 5px 10px;
            text-align: left;
            border: 1px solid black;
        }
    </style>
</head>

<body>
    <div id="map"></div>
    <input type="text" id="locationName" placeholder="Location Name">
    <button id="saveBtn">Save Location</button>

    <table id="locationTable">
        <thead>
            <tr>
                <th>Bookmarks</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>

    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
        var map = L.map('map').setView([51.505, -0.09], 13);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors',
            maxZoom: 18,
        }).addTo(map);

        var marker;

        map.on('click', function(e) {
            if (marker) {
                map.removeLayer(marker);
            }
            marker = L.marker(e.latlng).addTo(map);
        });

        $('#saveBtn').on('click', function() {
            var lat = marker.getLatLng().lat;
            var lng = marker.getLatLng().lng;
            var name = $('#locationName').val();

            $.ajax({
                type: 'POST',
                url: 'save_location.php',
                data: {
                    lat: lat,
                    lng: lng,
                    name: name
                },
                success: function(response) {
                    alert('Location saved successfully.');
                    // Clear input field after successful save
                    $('#locationName').val('');
                    // Reload table
                    loadLocationTable();
                },
                error: function(xhr, status, error) {
                    console.log(xhr.responseText);
                    alert('An error occurred while saving the location.');
                }
            });
        });

        function loadLocationTable() {
            $.ajax({
                type: 'GET',
                url: 'get_locations.php',
                dataType: 'json',
                success: function(response) {
                    var locations = response;
                    var tableBody = $('#locationTable tbody');
                    tableBody.empty();

                    for (var i = 0; i < locations.length; i++) {
                        var location = locations[i];
                        var row = '<tr>' +
                            '<td><a href="#" onclick="zoomToLocation(' + location.latitude + ', ' + location.longitude + ')">' + location.name + '</a></td>' +
                            '<td><button class="deleteBtn" data-id="' + location.id + '">Delete</button></td>' +
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

            $.ajax({
                type: 'POST',
                url: 'delete_location.php',
                data: {
                    id: locationId
                },
                success: function(response) {
                    alert('Location deleted successfully.');
                    // Reload table
                    loadLocationTable();
                },
                error: function(xhr, status, error) {
                    console.log(xhr.responseText);
                    alert('An error occurred while deleting the location.');
                }
            });
        });


        function zoomToLocation(latitude, longitude) {
            map.setView([latitude, longitude], 12);
        }



        // Load table on page load
        loadLocationTable();
    </script>
</body>

</html>