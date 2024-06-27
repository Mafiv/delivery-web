<?php 
require_once '../../database_connection.php';
session_start();
 
$cartId=$_SESSION['cart_id_comp'];


$latitude = null;
$longitude = null;
$query = "SELECT lat, lng FROM cart WHERE id = $cartId";
$result = $db->query($query);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $latitude = $row['lat'];
        $longitude = $row['lng'];

    }
    
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Show Current Location and Random Location</title>
    <style>
        #map {
            height: 400px;
            width: 100%;
        }
    </style>
</head>
<body>
    <div class="kast">
        <h1>My Current Location and customer Location</h1>
        <div id="map"></div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.7.1/leaflet.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.7.1/leaflet.css" />

    <button id="complete_<?php echo $cartId; ?>" onclick="comp('<?php echo $cartId; ?>')">Complete</button>

    <script>
        

        function initMap() {
    // Create a new map centered on the user's current location
    navigator.geolocation.getCurrentPosition(function(position) {
    var currentLatitude = position.coords.latitude;
    var currentLongitude = position.coords.longitude;

    var map = L.map('map').setView([currentLatitude, currentLongitude], 15);

    // Add OpenStreetMap tiles to the map
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: 'Map data © <a href="https://openstreetmap.org">OpenStreetMap</a> contributors',
        maxZoom: 18,
    }).addTo(map);

    // Add a marker at the user's current location
    L.marker([currentLatitude, currentLongitude]).addTo(map)
        .bindPopup('My Location')
        .openPopup();

    // Add a marker at the location from the database
    if (<?php echo $latitude; ?> !== null && <?php echo $longitude; ?> !== null) {
        L.marker([<?php echo $latitude; ?>, <?php echo $longitude; ?>]).addTo(map)
            .bindPopup('Location from Database')
            .openPopup();

        // Get the route between the current location and the location from the database
        var url = 'https://api.openrouteservice.org/v2/directions/driving-car?api_key=YOUR_API_KEY&start=' + currentLongitude + ',' + currentLatitude + '&end=' + <?php echo $longitude; ?> + ',' + <?php echo $latitude; ?>;

        fetch(url)
            .then(response => response.json())
            .then(data => {
                // Add the route to the map
                L.geoJSON(data.features[0].geometry).addTo(map);
            })
            .catch(error => console.error(error));
    }
}, function(error) {
    console.error("Error getting location:", error);
    // Handle the case where the user denies permission or geolocation is not supported
});
};

function comp(cartId){
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'complete.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onreadystatechange = function() {
        if (xhr.status === 200) {
            // Handle the response from the server
            window.open("http://localhost/delivery-web/organization%20side/delivery_man%20panel/homepage.php");
        } else {
            // console.log(xhr.readyState);
        }
    };
    console.log(cartId);
    xhr.send('cart_id=' + encodeURIComponent(cartId));
}
    </script>
    <script>
        // Load Leaflet and initialize the map
        var leafletScript = document.createElement('script');
        leafletScript.src = 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.7.1/leaflet.js';
        leafletScript.onload = function() {
            initMap();
        };
        document.head.appendChild(leafletScript);
    </script>
</body>
</html>