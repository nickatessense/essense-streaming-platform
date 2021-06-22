<?php /*Template Name: Session Tracker*/
	
	$serverName = "localhost";
	$username = "root";
	$password = "root";
	$dbname = "streamingplatform";

	$userID = get_current_user_id();
	$sessionID = session_id();
	$date = date("y-m-d");
	$loginTime = $_SESSION['loginTime'];


	//Create Connection
	$conn = new mysqli($serverName, $username, $password, $dbname);

	// Check Connection 
	if ($conn->connection_error) {
		// die("Connection failed: " . $conn->connection_error);
	}

	$sql = "INSERT INTO `sessionConnector` (`user_ID`, `session_ID`, `date`, `loginTime`) VALUES ($userID, '$sessionID', '$date', '$loginTime')";

	if ($conn->query($sql) === TRUE) {
	} else {
	  // echo "Error: " . $sql . "<br>" . $conn->error;
	}
	
	$conn->close();
	
?>