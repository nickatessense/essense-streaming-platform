<?php get_header(); /*Template Name: User Tracking Page*/ ?>
	
	<?php if(current_user_can('administrator')) { ?>
		<div class="content" id="userTracking">
			<div class="inner-content">
				<div class="heading">
					<div class="left">
						<h1>Welcome to the Dashboard</h1>
						<p>Here we have all the content that we have stored for each user. Please review and check what the users are doing on the site.</p>
					</div>
					<div class="right">
						<h2>Total Users Visits</h2>
						<?php
							$mysqli = new mysqli("localhost","root","root","streamingplatform");

							// Perform query
							if ($result = $mysqli -> query("SELECT COUNT(DISTINCT user_ID) FROM userViewed")) {
								$count = $result->num_rows;
							  	$result -> free_result();
							}

							$mysqli -> close();
						?>
						<p><?php echo $count; ?></p>
					</div>
				</div>
				<div class="dateRange">
					<h2>Events:</h2>
					<div class="events">
						<div class="btn">
							<a href=""><p>Event 1</p></a>
						</div>
						<div class="btn">
							<a href=""><p>Event 2</p></a>
						</div>
					</div>
					
					<h2>Date Range:</h2>
					<div class="ranges">
						<div class="btn">
							<a href=""><p>Today</p></a>
						</div>
						<div class="btn">
							<a href=""><p>Yesterday</p></a>
						</div>
						<div class="btn">
							<a href=""><p>Last Week</p></a>
						</div>
						<div class="btn">
							<a href=""><p>Last Month</p></a>
						</div>
						<div class="btn">
							<a href=""><p>Last 3 Months</p></a>
						</div>
						<div class="btn">
							<a href=""><p>Last Year</p></a>
						</div>
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
							$conn = new mysqli("localhost","root","root","streamingplatform");

							$sql = "SELECT page_ID, COUNT(page_ID) as c FROM userViewed GROUP BY page_ID ORDER BY COUNT(page_ID) DESC";
							$result = $conn->query($sql);


							if ($result->num_rows > 0) {
							  // output data of each row
							  while($row = $result->fetch_assoc()) {
							  	$title = get_the_title($row["page_ID"]);
							  	$count = $row["c"];?>
							    
							    <div class="element">
							    	<p><?php echo $title ?></p>
							    	<p><?php echo $count ?></p>
							    </div>
							  <?php }?>
							</div>
							<?php } else {
							  echo "0 results";
							}
							$conn -> close();
						?>
					</div>
					<div class="item">
						<h3>Documents Downloaded</h3>
						<div class="graph">
							<div class="top">
								<h4>File Name</h4>
								<h4>Count</h4>
							</div>
						<?php
							$conn = new mysqli("localhost","root","root","streamingplatform");

							// Check connection
							if ($conn->connect_error) {
							  die("Connection failed: " . $conn->connect_error);
							}

							$sql = "SELECT fileName, COUNT(fileName) as c FROM userDownload GROUP BY fileName ORDER BY COUNT(fileName) DESC";
							$result = $conn->query($sql);


							if ($result->num_rows > 0) {
							  // output data of each row
							  while($row = $result->fetch_assoc()) {
							  	$title = $row["fileName"];
							  	$count = $row["c"];?>
							    
							    <div class="element">
							    	<p><?php echo $title ?></p>
							    	<p><?php echo $count ?></p>
							    </div>
							  <?php }?>
							</div>
							<?php } else {
							  echo "0 results";
							}
							$conn -> close();
						?>
					</div>
					<div class="item">
						<h3>Calendar Invite Downloaded</h3>
						<div class="graph">
							<div class="top">
								<h4>Event Name</h4>
								<h4>Count</h4>
							</div>
						<?php
							$conn = new mysqli("localhost","root","root","streamingplatform");

							// Check connection
							if ($conn->connect_error) {
							  die("Connection failed: " . $conn->connect_error);
							}

							$sql = "SELECT eventName, COUNT(eventName) as c FROM userCalendarDownload GROUP BY eventName ORDER BY COUNT(eventName) DESC";
							$result = $conn->query($sql);


							if ($result->num_rows > 0) {
							  // output data of each row
							  while($row = $result->fetch_assoc()) {
							  	$name = $row["eventName"];
							  	$count = $row["c"];?>
							    
							    <div class="element">
							    	<p><?php echo $name ?></p>
							    	<p><?php echo $count ?></p>
							    </div>
							  <?php } ?>
							</div>
							<?php }else {
							  echo "0 results";?>
							</div>
							<?php }
							$conn -> close();
						?>
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