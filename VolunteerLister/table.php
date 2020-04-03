<!DOCTYPE html>
<html>
<head>
<title>Table View of Volunteer Opportunities</title>

<style>
				table, th, td {
				border-collapse: collapse;
				  table-layout: fixed ;

				width: 100%;
				color: #588c7e;
				border: 1px solid black; 
				border-collapse: collapse;
				font-family: monospace;
				font-size: 14px;
				text-align: center;
				}
				h6{
				font-family: monospace;
				font-size: 18px;
				}

				th {
				background-color: #588c7e;
				color: white;
				}
				a:hover{
					  background-color: yellow;

				}

			.topright{
              position: absolute;
              top: 0px;
              right: 350px;
              font-family: monospace;
			font-size: 18px;
            }
tr:nth-child(even) {background-color: #f2f2f2}
</style>

</head>
<body>

                <div class="topright"> <a href="index.html">Submit</a>  &emsp; <a href="table.php">Table</a> &emsp; <a href="output.php">Map</a> </div>
      <h6> Volunteer Opportunities Table!</h6>

<table>
<tr>
			<th> Volunteer Title </th>
			<th> Organization </th>
			<th> Level </th>
			<th> Description </th>
			<th> Website </th>
			<th> Contact Name </th>
			<th> Contact Email </th>
			<th> Latitude </th>
			<th> Longitude </th>
			<th> Address </th>
</tr>



<?php
// Establishing a Connection
$conn = mysqli_connect("localhost", "root", "", "volunteer_list");

// Check connection
	if ($conn->connect_error) {
		// Error in the Connection
		die("Connection failed: " . $conn->connect_error);
	}

// SELECT ALL from the table called "opportunity"
$sql = "SELECT * FROM opportunity";
$result = $conn->query($sql);

	// If there is table data
	if ($result->num_rows > 0) {
	// output data of each row converting table values into HTML format
		while($row = $result->fetch_assoc()) {
			echo "<tr><td>" . $row["volunteer_Title"]. "</td><td>" . $row["organization"] . "</td><td>"
. $row["level"]. "</td><td>" . $row["description"] . "</td><td>" . '<a href=' . $row["website"] . '>' . "URL" . '</a>' . "</td><td>" . $row["contactName"] . "</td><td>" . $row["contactEmail"] . "</td><td>" . $row["lat"] . "</td><td>" . $row["lon"] . "</td><td>" . $row["locationoutput"] . "</td></tr>";
		}
			echo "</table>";
		} 		
		// If there's nothing in the table
		else { echo "0 results"; }
$conn->close();
?>
</table>

</body>
