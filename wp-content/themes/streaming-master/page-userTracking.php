<?php 
get_header(); /*Template Name: User Tracking Page*/ 

require_once(get_template_directory() . '/functions/analytics/page_functions/userTracking_helper_functions.php');

/**
 * Prepares $dateQuery variable to filter out data by specific date or date range 
 * Otherwise query will be empty string and allow SQL query to show all dates
 */
if (checkDateFormat($eventDate)) { // if date is of format "Y-m-d", then user wants specific date
	$dateQuery = "WHERE date = '$eventDate'";
}else if(!empty($eventDate)){ 
	// if date is not specified format above and isn't empty we'll use strtotime to interpret date
	// Then provide a range for the interpretted date to today
	$date = str_replace('_', " ", $eventDate);
	$date = date("Y-m-d",strtotime($date)); 
	$today = date("Y-m-d");
	$dateQuery = "WHERE date BETWEEN '$date' AND '$today'";
}else{ // otherwise date query will be empty and allow sql query to show all dates
	$dateQuery = '';
}

$requestedUserId = $_GET['user'];

/**
 * Joins dateQuery and appends user query to $additionalQuery
 */
if( !empty($dateQuery) && !empty($requestedUserId) ){ // if date and user are specified
	
	// Searches by dateQuery and user id
	$additionalQuery = $dateQuery . " AND user_id = '$requestedUserId'";

}else if (empty($dateQuery) && !empty($requestedUserId) && is_int($requestedUserId)) { // If only user is specified
	
	$additionalQuery = "WHERE user_id = '$requestedUserId'";

}else if( !empty($dateQuery) && empty($requestedUserId) ){ // only date is specified
	
	$additionalQuery = $dateQuery;

}else{
	$additionalQuery = '';
}


// Retrieves data from database 
$eventDate = $_GET['eventDate'];
$pageViews = getPageViews($additionalQuery);
$downloads = getDownloads($additionalQuery);
$calendarDownloads = getCalendarDownloads($additionalQuery);
$averageVideoTimes = getAverageUserWatchTime($additionalQuery);

$averageVideoTime = $averageVideoTimes['all'];

?>
	
	<?php if(current_user_can('administrator')) { ?>

		<div class="content" id="userTracking">
			<div class="inner-content">
				<div class="heading">
				<div class="left">
					<h1>Welcome to the Dashboard</h1>
					<p>Where you can keep an eye on trending content, user engagement and key customer activities.</p>
				</div>
				<div class="right">
					<h2>Average User watch time</h2>
					<p><?php echo $averageVideoTime ?></p>
				</div>
			</div>
				<div class="dateRange">
					<h2>Events:</h2>
					<div class="events">
						<p>Get data by specific date</p>
						<form method="get">
							<input type="date" value="<?php echo $eventDate ?>" name="eventDate">
							<input type="submit" value="Get Data">
						</form>
					</div>
					
					<h2>Date Range:</h2>
					<div class="ranges">
						<div class="btn">
							<a href="./?eventDate=today"><p>Today</p></a>
						</div>
						<div class="btn">
							<a href="./?eventDate=yesterday"><p>Yesterday</p></a>
						</div>
						<div class="btn">
							<a href="./?eventDate=-1_week"><p>Last Week</p></a>
						</div>
						<div class="btn">
							<a href="./?eventDate=-1_month"><p>Last Month</p></a>
						</div>
						<div class="btn">
							<a href="./?eventDate=-3_months"><p>Last 3 Months</p></a>
						</div>
						<div class="btn">
							<a href="./?eventDate=-1_year"><p>Last Year</p></a>
						</div>
					</div>

					<div style="margin-bottom: 2em;">
						<form method="get">
							<h2>Search by users</h2>
							<?php wp_dropdown_users(['selected' => $requestedUserId]); ?>
							<input type="submit" value="Get Data">
						</form>
						<a href="/user-data">
							<button style="padding:.5em 1em; margin-top: 1em;">See all user data</button>
						</a>
					</div>


				</div>
				<div class="general">
					<div class="item">
						<h3>Page Viewed</h3>
						<div class="graph">
							<div class="top">
								<h4>Title</h4>
								<h4>Count</h4>
							</div>
						<?php 
						if (count($pageViews) > 0) {
							foreach($pageViews as $pageView){
								$titleId = $pageView->page_ID;
								$pageVisits = $pageView->pageVisits;
								?>
								<div class="element">
							    	<p><?php echo get_the_title($titleId) ?></p>
							    	<p><?php echo $pageVisits ?></p>
							    </div>
								<?php
							}
						}else{
							echo "0 results";
						}?>

							</div>
					</div>
					<div class="item">
						<h3>Documents Downloaded</h3>
						<div class="graph">
							<div class="top">
								<h4>File Name</h4>
								<h4>Count</h4>
							</div>
							<?php
								if (count($downloads) > 0) {
									foreach($downloads as $download){
										$title = $download->fileName;
										$count = $download->downloadCount;

										?>
										<div class="element">
									    	<p><?php echo $title ?></p>
									    	<p><?php echo $count ?></p>
									    </div>
										<?php

									}
								}else{
									echo "0 results";
								}
							?>
						</div>
					</div>
					<div class="item">
						<h3>Calendar Invite Downloaded</h3>
						<div class="graph">
							<div class="top">
								<h4>Event Name</h4>
								<h4>Count</h4>
							</div>

							<?php
								if (count($calendarDownloads) > 0) {
									foreach($calendarDownloads as $calendarDownload){
										$title = $calendarDownload->eventName;
										$count = $calendarDownload->count;

										?>
										<div class="element">
									    	<p><?php echo $title ?></p>
									    	<p><?php echo $count ?></p>
									    </div>
										<?php

									}
								}else{
									echo "0 results";
								}
							?>
						</div>
					</div>
					<div class="item">
						<h3>Average Video Watch Time</h3>
						<div class="graph">
							<div class="top">
								<h4>Video Title</h4>
								<h4>Average Time</h4>
							</div>

							<?php
								unset($averageVideoTimes['all']); // already being displayed

								if (!empty($averageVideoTimes) && count($averageVideoTimes) > 0) {
									foreach($averageVideoTimes as $title => $averageVideoTime){
										?>
										<div class="element">
									    	<p><?php echo $title ?></p>
									    	<p><?php echo $averageVideoTime ?></p>
									    </div>
										<?php

									}
								}else{
									echo "0 results";
								}
							?>
						</div>
					</div>
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
		
		<?php get_footer(); ?>
		<script type="text/javascript">
			window.location.href = "<?php echo home_url(); ?>";
		</script>
	<?php } ?>
<?php get_footer(); ?>