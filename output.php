<?php

// Creating and Establishing the PHP connection
$conn = new mysqli("localhost", "root", "", "volunteer_list");
// Connection Failed
if ($conn->connect_error) {
     die("Connection failed: " . $conn->connect_error);
} 

// Query to grab the data
$sql = "SELECT * from opportunity";
$result = $conn->query($sql);

// Creating Arrays for the data
$lat_array = $lon_array = $id_array = $level_array  = $volunteerTitle_array = $organization_array = $description_array = $website_array = $location_output_array  = array();

// Pushing the data into these arrays
if ($result->num_rows > 0) {

    // output data of each row
    while($row = $result->fetch_assoc()) {
     	array_push($lat_array, $row["lat"]);
     	array_push($lon_array, $row["lon"]);
     	array_push($id_array, $row["id"]);
     	array_push($level_array, $row["level"]);
     	array_push($volunteerTitle_array, $row["volunteer_Title"]);
     	array_push($organization_array, $row["organization"]);
     	array_push($description_array, $row["description"]);
     	array_push($website_array, $row["website"]);
     	array_push($location_output_array, $row["locationoutput"]);
     }
 } 
 else {
 	echo "0 results";
 }

$conn->close();
?>  

<!DOCTYPE html>
<html>
<head>
	
	<title>Volunteering Opportunities Map</title>

	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	
	<link rel="shortcut icon" type="image/x-icon" href="docs/images/favicon.ico" />

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.6.0/dist/leaflet.css" integrity="sha512-xwE/Az9zrjBIphAcBb3F6JVqxf46+CDLwfLMHloNu6KEQCAWi6HcDUbeOfBIptF7tcCzusKFjFw2yuvEpDL9wQ==" crossorigin=""/>

    <script src="https://unpkg.com/leaflet@1.6.0/dist/leaflet.js" integrity="sha512-gZwIG9x3wUXg2hdXF6+rVkLF/0Vi9U8D2Ntg4Ga5I5BZpVkVxlJWbSQtXPSiUTtC0TjtGOmxa1AJPuV0CPthew==" crossorigin=""></script>


	<style>
		html, body {
			height: 100%;
			margin: 0;
		}
		
		#map {
			width:90%;height:75%;padding:50px;margin:20px; 
			position: absolute;
  			top: 50px;
		}


		.topright{
             position: absolute;
             top: 0px;
             right: 350px;
             font-family: monospace;
			font-size: 18px;
            }
        h6{
            font-family: monospace;
            font-size: 18px;
            }
            a:hover{
				background-color: yellow;
			}
	</style>
	
</head>

<body>
    <div class="topright"> <a href="index.html">Submit</a>  &emsp; <a href="table.php">Table</a> &emsp; <a href="output.php">Map</a> </div>
    <h6>Volunteering Opportunities Map!</h6>


<div id='map'></div>

<script>

	// Icon Colours (don't need to create a blue one as it's the default colour)
	var greenIcon = new L.Icon({
 	iconUrl: 'https://cdn.rawgit.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-green.png',
  	shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',
  	iconSize: [25, 41],
  	iconAnchor: [12, 41],
  	popupAnchor: [1, -34],
  	shadowSize: [41, 41]
	});
	// Icon Colours
	var purpleIcon = new L.Icon({
 	iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-violet.png',
  	shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',
  	iconSize: [25, 41],
  	iconAnchor: [12, 41],
  	popupAnchor: [1, -34],
  	shadowSize: [41, 41]
	});
	// Map Layers (to improve the User Experience)
	var junior = L.layerGroup();
	var intermediate = L.layerGroup();
	var senior = L.layerGroup();

	// Converting php variables to JAVASCRIPT
	var lats = <?php echo json_encode($lat_array); ?>;
	var lons = <?php echo json_encode($lon_array); ?>;

	// Classifying
	var levels = <?php echo json_encode($level_array); ?>;

	// Windows to Display 
	var voltitles =  <?php echo json_encode($volunteerTitle_array); ?>;
	var organizations =  <?php echo json_encode($organization_array); ?>;
	var websites =  <?php echo json_encode($website_array); ?>;
	var descriptions =  <?php echo json_encode($description_array); ?>;
	var address_labels =  <?php echo json_encode($location_output_array); ?>;

	// Looping through the variables, if its junior, creates a green marker, if intermediate creates a purple icon, if senior creates a default marker (blue)
	var arrayLength = lats.length;
	for (var i = 0; i < arrayLength; i++) {
		if (levels[i] == "j"){
					L.marker([lats[i],lons[i]],{icon: greenIcon}).bindPopup('<b>Title:</b> ' + voltitles[i] + '<br>' + '<b>Organization: </b>' + organizations[i] + '<br>' + '<b>Website: </b>' +
					 '<a href=' + websites[i] + '>Click Here</a>' + '<br>' + '<b>Description: </b>' + descriptions[i] + '' + '<br>' + '<b>Address: </b>' + address_labels[i]).addTo(junior);
		}
		else if (levels[i] == "i"){
										L.marker([lats[i],lons[i]], {icon: purpleIcon}).bindPopup('<b>Title:</b> ' + voltitles[i] + '<br>' + '<b>Organization: </b>' + organizations[i] + '<br>' + '<b>Website: </b>' +
					 '<a href=' + websites[i] + '>Click Here</a>' + '<br>' + '<b>Description: </b>' + descriptions[i] + '' + '<br>' + '<b>Address: </b>' + address_labels[i]).addTo(intermediate);
		}

		else if (levels[i] == "s"){
										L.marker([lats[i],lons[i]]).bindPopup('<b>Title:</b> ' + voltitles[i] + '<br>' + '<b>Organization: </b>' + organizations[i] + '<br>' + '<b>Website: </b>' +
					 '<a href=' + websites[i] + '>Click Here</a>' + '<br>' + '<b>Description: </b>' + descriptions[i] + '' + '<br>' + '<b>Address: </b>' + address_labels[i]).addTo(senior);
		}
	}

	var mbAttr = 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, ' +
			'<a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, ' +
			'Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
		mbUrl = 'https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw';

	// Base Maps in the Layer
	var grayscale   = L.tileLayer(mbUrl, {id: 'mapbox/light-v9', tileSize: 512, zoomOffset: -1, attribution: mbAttr}),
		streets  = L.tileLayer(mbUrl, {id: 'mapbox/streets-v11', tileSize: 512, zoomOffset: -1, attribution: mbAttr});

	var map = L.map('map', {
		center: [43.468668, -80.542548],
		zoom: 15,
		layers: [grayscale, junior, intermediate, senior]
	});

	// Base Maps
	var baseLayers = {
		"Grayscale": grayscale,
		"Streets": streets
	};
	// Check Box Layers 
	var overlays = {
		"Junior": junior,
		"Intermediate": intermediate,
		"Senior": senior
	};

	L.control.layers(baseLayers, overlays).addTo(map);
</script>
</body>
</html>