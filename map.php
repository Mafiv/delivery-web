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
        <h1>My Current Location and Random Location</h1>
        <div id="map"></div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.7.1/leaflet.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.7.1/leaflet.css" />

    <script>
        function getRandomLocation(latitude, longitude, radius) {
            // Convert radius from miles to meters
            var radiusInMeters = radius * 1609.34;

            // Convert latitude and longitude to radians
            var lat = latitude * (Math.PI / 180);
            var lng = longitude * (Math.PI / 180);

            // Calculate a random angle
            var angle = Math.random() * 2 * Math.PI;

            // Calculate the new latitude and longitude
            var newLat = lat + (radiusInMeters / 6371000) * Math.cos(angle);
            var newLng = lng + (radiusInMeters / 6371000) * Math.sin(angle) / Math.cos(lat);

            // Convert new latitude and longitude back to degrees
            newLat = newLat * (180 / Math.PI);
            newLng = newLng * (180 / Math.PI);

            return { lat: newLat, lng: newLng };
        }

        function initMap() {
            // Create a new map centered on the user's current location
            navigator.geolocation.getCurrentPosition(function(position) {
                var latitude = position.coords.latitude;
                var longitude = position.coords.longitude;

                var map = L.map('map').setView([latitude, longitude], 15);

                // Add OpenStreetMap tiles to the map
                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: 'Map data © <a href="https://openstreetmap.org">OpenStreetMap</a> contributors',
                    maxZoom: 18,
                }).addTo(map);

                // Add a marker at the user's current location
                L.marker([latitude, longitude]).addTo(map)
                    .bindPopup('My Location')
                    .openPopup();

                // Generate a random location approximately 1 mile away from the user's current location
                var randomLocation = getRandomLocation(latitude, longitude, 1);

                // Add a marker for the random location
                L.marker([randomLocation.lat, randomLocation.lng]).addTo(map)
                    .bindPopup('Random Location')
                    .openPopup();
            });
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