<?php /*Template Name: Download Tracker*/

	session_start();
	
	// echo "string";
	$serverName = "localhost";
	$username = "root";
	$password = "root";
	$dbname = "streamingplatform";

	$userID = get_current_user_id();

	// Get file name from URL parameter
	$fileName = $_GET['title'];

	$time = date("H:i:s");
	$date = date("Y-m-d");
	$session_ID = session_ID();

	//Create Connection
	$conn = new mysqli($serverName, $username, $password, $dbname);

	// Check Connection 
	if ($conn->connection_error) {
		die("Connection failed: " . $conn->connection_error);
	}

	$sql = "INSERT INTO `userDownload` (`user_ID`, `fileName`, `date`, `time`, `session_ID`) VALUES ($userID, '$fileName', '$date', '$time', '$session_ID')";

	if ($conn->query($sql) === TRUE) {
	} else {
	  echo "Error: " . $sql . "<br>" . $conn->error;
	}

	$conn->close();
?>