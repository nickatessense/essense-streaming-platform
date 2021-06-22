<?php 
	
	$serverName = "localhost";
	$username = "root";
	$password = "root";
	$dbname = "streamingplatform";

	$userID = get_current_user_id();
	$pageID = get_the_ID();
	$time = date("H:i:s");
	$date = date("Y-m-d");
	$sessionID = session_id();


	global $wpdb;
	$results = $wpdb->insert(
		'userViewed',
		array(
			'user_ID' => $userID,
			'page_ID' => $pageID,
			'time' => $time,
			'date' => $date,
			'session_ID' => $sessionID
		),
	);
	
	//Create Connection
	// $conn = new mysqli($serverName, $username, $password, $dbname);

	// // Check Connection 
	// if ($conn->connection_error) {
	// 	die("Connection failed: " . $conn->connection_error);
	// }

	// $sql = "INSERT INTO `userViewed` (`user_ID`, `page_ID`, `time`, `date`, `session_ID`) VALUES ($userID, $pageID, '$time', '$date', '$sessionID')";

	// if ($conn->query($sql) === TRUE) {
	// } else {
	//   echo "Error: " . $sql . "<br>" . $conn->error;
	// }

	// $conn->close();
?>