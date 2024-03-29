<?php

/**
 * Shortcode for displaying youtube embedded videos with iframe api to enable video tracking 
 */
function essense_partners_youtube_video_shortcode($attrs){

    $content = "<div id='essense-partners-youtube-vid' data-vid-src='".$attrs['youtube_url']."'></div>";

    return $content;
}

add_shortcode('essense_partners_youtube_video', 'essense_partners_youtube_video_shortcode' );

/**
 * Updates or inserts data into analytics_video_percentage table
 */
function essense_partners_update_video_percentage_table(){

    global $wpdb;

    $user_id = get_current_user_id();
    $session_id = wp_get_session_token();
    $today = date("Y-m-d");
    $table_name = 'analytics_video_time_tracker';
    $video_title = $_POST['videoTitle'];

    $videoDuration = round($_POST['videoDuration']);

    $videoUrl = $_POST['videoUrl'];

    // Cleans up title to only allow alphanumeric
    $video_title = preg_replace("/[^A-Za-z0-9]/", ' ', $video_title);
    $video_title = preg_replace("/\s+/", ' ', $video_title);

    if (empty($video_title)) {
        echo 'No title';
        wp_die();
    }

    $timeSpentOnVideoInSeconds= $_POST['time'];

    $referrer_link = wp_get_referer();

    // If table does not exist, create it
    maybe_create_table( $table_name, "
        CREATE TABLE `$table_name` 
        (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `user_id` int(11) NOT NULL,
            `video_title` text NOT NULL,
            `date` date NOT NULL,
            `seconds_spent_on_vid` int(11) NOT NULL,
            `video_duration_seconds` int(11) NOT NULL,
            `session_id` text NOT NULL,
            `update_count` int(11) NOT NULL,
            `site_url` text NOT NULL,
            `video_url` text NOT NULL,
            PRIMARY KEY (id)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8;" 
    );

    $result = $wpdb->get_results ( "
        SELECT * 
        FROM $table_name
        WHERE user_id = '$user_id' 
        AND video_title = '$video_title'
        AND session_id = '$session_id' 
        AND date = '$today'
        AND site_url = '$referrer_link'
        ORDER BY id DESC LIMIT 1
    ");

    if (!empty($result) && count($result) == 1) {
        $lastTimeRecordedInSeconds = $result[0]->seconds_spent_on_vid;
        $lastTimeRecordedInSecond = $lastTimeRecordedInSeconds + $timeSpentOnVideoInSeconds;

        $result = $wpdb->update( $table_name,
            [
                'video_title' => $video_title,
                'seconds_spent_on_vid' => $lastTimeRecordedInSecond,
                'video_duration_seconds' => $videoDuration,
                'video_url' => $videoUrl,
                'update_count' => $result[0]->update_count + 1,
            ],
            [
                'user_id' => $user_id,
                'date' => $today,
                'video_title' => $video_title,
                'session_ID' => $session_id,
                'site_url' => $referrer_link

            ]
        );

    }else{
        $result = $wpdb->insert(
             $table_name,
            [
                'user_id' => $user_id,
                'video_title' => $video_title,
                'date' => $today,
                'seconds_spent_on_vid' => $timeSpentOnVideoInSeconds,
                'video_duration_seconds' => $videoDuration,
                'session_ID' => $session_id,
                'update_count' => 1,
                'site_url' => $referrer_link,
                'video_url' => $videoUrl,
            ],
        );
    }

    $wpdb->close();

    wp_die();

}

add_action('wp_ajax_time_spent_on_vid', 'essense_partners_update_video_percentage_table' );


