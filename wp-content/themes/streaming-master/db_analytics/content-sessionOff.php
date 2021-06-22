<?php /*Template Name: Session Off Tracker*/
	
	$serverName = "localhost";
	$username = "root";
	$password = "root";
	$dbname = "streamingplatform";

	$logoutTime = date("H:i:s");


	//Create Connection
	$conn = new mysqli($serverName, $username, $password, $dbname);

	// Check Connection 
	if ($conn->connection_error) {
		// die("Connection failed: " . $conn->connection_error);
	}

	$sql = "UPDATE `sessionConnector` SET `logoutTime`= '$logoutTime' order by id DESC LIMIT 1";

	if ($conn->query($sql) === TRUE) {
	} else {
	  // echo "Error: " . $sql . "<br>" . $conn->error;
	}

	$conn->close();

	session_destroy()();

?>