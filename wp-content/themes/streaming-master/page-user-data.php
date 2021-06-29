<?php

/*Template Name: User Data Page*/ 

get_header();

$date = $_GET['date'];
$requestedUserId = $_GET['user'];


if (!empty($date) && checkDateFormat($date) && !empty($requestedUserId) && $requestedUserId != 'All') {
	// If date isset and correct format and requestedUserId is set and correct format then set the query to below
	$query = "WHERE date = '$date' AND user_id = '$requestedUserId' ";
}else if(empty($date) && !empty($requestedUserId) && $requestedUserId != 'All'){
	// if date is empty but $requestedUserId and is in correct format 
	$query = "WHERE user_id = '$requestedUserId' ";
}else if(!empty($date) && checkDateFormat($date) && (empty($requestedUserId) OR $requestedUserId == 'All' ) ){
	// Date is specified but user is not or option is set to 'All'
	$query = "WHERE date = '$date'";
}else{ // blank query, retrieve all data
	$query = '';
}


$videoData = getUserWatchTime($query);
$calendarDownloads = getCalendarDownloads($query);
$downloads = getDownloads($query);

function getUserWatchTime($query){
	global $wpdb;
	$sql = "
		SELECT *
		FROM analytics_video_time_tracker
		$query
	";

	$results = $wpdb->get_results($sql);

	return $results;
}

function getCalendarDownloads($query){

	global $wpdb;
	$sql = "
		SELECT *
		FROM userCalendarDownload
		$query
	";

	return $wpdb->get_results($sql);

}

function getDownloads($query){
	global $wpdb;
	$sql = "
		SELECT *
		FROM userDownload
		$query
	";

	return $wpdb->get_results($sql);
}

$vidCount =0;
foreach($videoData as $data){
	$vidCount+=1;
	$time = $data->seconds_spent_on_vid;
}

$averageVideoTime = round($time / $vidCount);

$averageVideoTime = $averageVideoTime > 0 ? $averageVideoTime : 0;

echo "<pre style='background-color:white; bottom:0; left:0; max-width:25%; position:fixed; z-index:99999; ' >";

echo "</pre>";


?>

<?php if(current_user_can('administrator')) { ?>

	<style type="text/css">
		.essense-partners-table{
			width: 100%;
		}

		.essense-partners-table th{
			padding-top: 12px;
			padding-bottom: 12px;
			text-align: left;
			background-color: #04AA6D;
			color: white;
		}

		.essense-partners-table td, .essense-partners-table th {
			border: 1px solid #ddd;
			padding: 8px;
			min-width: 10%;
			max-width: calc(100%/6);
			text-align: center;
		}


	</style>

	<div class="content" id="User Data">
		<div class="inner-content">
			<div class="heading">
				<div class="left">
					<h1>Welcome to the Dashboard</h1>
					<p>Where you can keep an eye on trending content, user engagement and key customer activities.</p>
				</div>
			</div>
			<div>

				<form>
					<h3>Filter by:</h3>
					<input id="dataDate" type="date" name="date" value="<?php echo $date; ?>">
					<button type="button" onclick="dataDate.value = '';" >Clear Date</button>
					<?php wp_dropdown_users(['show_option_all'=> 'All Users', 'selected' => $requestedUserId]); ?>
					<input class="btn" type="submit">
				</form>

				<h3 style="margin-top:3em;">Video Data</h3>
				<table class="essense-partners-table">
					<thead>
						<tr>
							<th>User</th>
							<th>Video</th>
							<th>Date</th>
							<th>Time</th>
							<th>Video Length</th>
							<th>Site Url</th>
							<th>Total Percentage Watched</th>
						</tr>
					</thead>
					<tbody>
					<?php

					if (!empty($videoData) && count($videoData) > 0) {
						foreach($videoData as $user_watch_time){
							$time_spent = $user_watch_time->seconds_spent_on_vid;
							$time_duration = $user_watch_time->video_duration_seconds;
							$time_spent = $time_spent > $time_duration ? $time_duration : $time_spent; 

							$percentage = round(($time_spent/$time_duration)*100, 2);

							$time_spent = gmdate("H:i:s", $time_spent);
							$time_duration = gmdate("H:i:s", $time_duration);

							echo '<tr>';
							echo '<td>' . get_userdata($user_watch_time->user_id)->display_name . '</td>';
							echo '<td> <a target="_blank" href="'.$user_watch_time->video_url.'">' . $user_watch_time->video_title . '</a.></td>';
							echo '<td>' . $user_watch_time->date . '</td>';
							echo "<td>$time_spent</td>";
							echo "<td>$time_duration</td>";
							echo "<td>". $user_watch_time->site_url ."</td>";
							echo "<td>$percentage%</td>";
							echo '<tr>';
						}
					}else{
						echo "<tr><td colspan='7'>0 results</td></tr>";
					}
					?>
					</tbody>
				</table>

				<h3 style="margin-top:3em;">Calendar Download Data</h3>
				<table class="essense-partners-table">
					<thead>
						<tr>
							<th>User</th>
							<th>Event</th>
							<th>Date</th>
							<th>Time</th>
						</tr>
					</thead>
					<tbody>
					<?php

					if (!empty($calendarDownloads) && count($calendarDownloads) > 0) {
						foreach($calendarDownloads as $download){
							echo '<tr>';
							echo '<td>' . get_userdata($download->user_ID)->display_name . '</td>';
							echo '<td>' . $download->eventName . '</td>';
							echo '<td>' . $download->date . '</td>';
							echo '<td>' . $download->time . '</td>';
							echo '<tr>';
						}
					}else{
						echo "<tr><td colspan='4'>0 results</td></tr>";
					}
					?>
					</tbody>
				</table>

				<h3 style="margin-top:3em;">Download Data</h3>
				<table class="essense-partners-table">
					<thead>
						<tr>
							<th>User</th>
							<th>Filename</th>
							<th>Date</th>
							<th>Time</th>
						</tr>
					</thead>
					<tbody>
					<?php

					if (!empty($downloads) && count($downloads) > 0) {
						foreach($downloads as $download){
							echo '<tr>';
							echo '<td>' . get_userdata($download->user_ID)->display_name . '</td>';
							echo '<td>' . $download->fileName . '</td>';
							echo '<td>' . $download->date . '</td>';
							echo '<td>' . $download->time . '</td>';
							echo '<tr>';
						}
					}else{
						echo "<tr><td colspan='4'>0 results</td></tr>";
					}

					?>
					</tbody>
				</table>

			</div>
		</div>
	</div>



	<div class="sidebar">
		<?php get_sidebar(); ?>
	</div>

<?php } else{ ?>
		<div class="content">
			<div class="inner-content">
				<h1>Seems like you got lost!</h1>
				<p>Redirecting you back to the homepage</p>
			</div>
		</div>
		<div class="sidebar">
    		<?php get_sidebar(); ?>
    	</div>
	<?php } ?>
<?php get_footer(); ?>