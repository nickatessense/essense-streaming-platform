<?php /*Template Name: Download Cal Invite*/
	
	session_start();
	
	// echo "string";
	// $serverName = "localhost";
	// $username = "root";
	// $password = "root";
	// $dbname = "streamingplatform";

	$userID = get_current_user_id();

	// Get file name from URL parameter
	$fileName = $_GET['title'];

	$time = date("H:i:s");
	$date = date("Y-m-d");

	$sessionID = session_id();

	global $wpdb;
	$results = $wpdb->insert(
		'userCalendarDownload',
		array(
			'user_ID' => $userID,
			'eventName' => $fileName,
			'date' => $date,
			'time' => $time,
			'session_ID' => $sessionID
		),
	);


	//Create Connection
	// $conn = new mysqli($serverName, $username, $password, $dbname);

	// Check Connection 
	// if ($conn->connection_error) {
	// 	die("Connection failed: " . $conn->connection_error);
	// }

	// $sql = "INSERT INTO `userCalendarDownload` (`user_ID`, `eventName`, `date`, `time`, `session_ID`) VALUES ($userID, '$fileName', '$date', '$time', '$sessionID')";

	// if ($conn->query($sql) === TRUE) {
	// } else {
	//   echo "Error: " . $sql . "<br>" . $conn->error;
	// }

	// $conn->close();
?>