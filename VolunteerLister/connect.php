<?php
	
	// Posting to the PHP database
	$volunteerTitle = $_POST['volunteerTitle'];
	$organization = $_POST['organization'];
	$level = $_POST['level'];
	$description = $_POST['description'];
	$website = $_POST['website'];
	$contactName = $_POST['contactName'];
	$contactEmail = $_POST['contactEmail'];
	$lat = $_POST['lat'];
	$lon = $_POST['lon'];
	$locationoutput = $_POST['locationoutput'];


	//DataBase Connection (establishing a connection)
	// localhost, root connection, password, database name
	$conn = new mysqli('localhost', 'root', '', 'volunteer_list');

	// Error Connecting to Database
	if($conn->connect_error){
		die('Connection Failed : '.$conn->connect_error);
	}

	// Successful Connecting to Database
	else{

		// Importing the Variables (from form) into the database 
		$stmt = $conn->prepare("insert into opportunity(volunteer_Title,organization,level,description,website,contactName,contactEmail,lat,lon,locationoutput)
			values(?,?,?,?,?,?,?,?,?,?)");

		// s = string, d = decimal
		$stmt->bind_param("sssssssdds",$volunteerTitle,$organization,$level,$description,$website,$contactName,$contactEmail,$lat,$lon,$locationoutput);

		$stmt->execute();

		// Successful Registration
		$message = "Registration Successful";
		echo "<script type='text/javascript'>alert('$message');</script>";

		// Redirects to the Table Page
		header("Refresh:0; url=table.php");

		$stmt->close();
		$conn->close();

	}
?>