<?php

/**
 * Get Page Views from Database,
 * $query variable, is for additonal conditions to append to query
 */
function getPageViews($query = ''){

	global $wpdb;

	$sql = "
		SELECT page_ID, 
		COUNT(page_ID) as pageVisits 
		FROM userViewed
		$query
		GROUP BY page_ID 
		ORDER BY COUNT(page_ID) 
		DESC
	";

	return $wpdb->get_results($sql);

}


/**
 * Returns filename download info from database 
 * $query variable, is for additonal conditions to append to query
 */
function getDownloads($query = ''){

	global $wpdb;

	$sql = "
		SELECT fileName, 
		COUNT(fileName) as downloadCount
		FROM userDownload 
		$query
		GROUP BY fileName 
		ORDER BY COUNT(fileName) 
		DESC
	";

	return $wpdb->get_results($sql);

}

/**
 * Returns calendar download info from database 
 * $query variable, is for additonal conditions to append to query
 */
function getCalendarDownloads($query = ''){

	global $wpdb;

	$sql = "
		SELECT eventName, 
		COUNT(eventName) as count 
		FROM userCalendarDownload 
		$query
		GROUP BY eventName 
		ORDER BY COUNT(eventName) 
		DESC
	";

	return $wpdb->get_results($sql);
}

// Returns count of unique vistors
function getTotalUniqueUserVisits(){
	global $wpdb;
	$sql = "SELECT DISTINCT user_ID FROM userViewed";
	return count($wpdb->get_results($sql));
}


/**
 * Returns an array of videoTitles with their average times
 * $query variable, is for additonal conditions to append to query
 */
function getAverageUserWatchTime($query = ''){
	$videosAverageTime; // Return value

	global $wpdb;
	$sql = "
		SELECT video_title, GROUP_CONCAT(seconds_spent_on_vid) as time
		FROM analytics_video_time_tracker
		$query
		GROUP BY video_title
	";

	$results = $wpdb->get_results($sql);

	if (empty($results)) {
		$videosAverageTime['all'] = 0;
		return $videosAverageTime;
	}

	$allVideosAverageTime = 0; // Will keep track of all videos average time
	$videoCount = 0; // Will keep track of videos counted to find total average at end

	// Gets the average time of all videos and adds them to $videosAverageTime
	foreach($results as $result){
		$title = $result->video_title;
		$times = explode(',',$result->time);

		$averageTime = 0; // Will keep track of single video average time

		foreach($times as $time){
			$videoCount += 1;
			$averageTime += $time;
			$allVideosAverageTime += $time;
		}

		$averageTime = round($averageTime / count($times));

		$videosAverageTime[$title] = gmdate("H:i:s", $averageTime);
	}

	// Gets average time of all videos
	$allVideosAverageTime = round($allVideosAverageTime / $videoCount);
	$videosAverageTime['all'] = gmdate("H:i:s", $allVideosAverageTime);

	return $videosAverageTime;
}