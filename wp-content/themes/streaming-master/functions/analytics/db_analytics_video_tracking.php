<?php

/**
 * Shortcode for displaying youtube embedded videos with iframe api to enable video tracking 
 */
function essense_partners_youtube_video_shortcode($attrs){

    $content = "<h1>Hello World!</h1>";

    $content .= "<div id='essense-partners-youtube-vid' data-vid-src='".$attrs['youtube_url']."'></div>";

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
    $table_name = $wpdb->prefix . 'analytics_video_percentage';
    $video_title = $_POST['videoTitle'];

    // Cleans up title to only allow alphanumeric
    $video_title = preg_replace("/[^A-Za-z0-9]/", ' ', $video_title);
    $video_title = preg_replace("/\s+/", ' ', $video_title);

    $timeSpentOnVideoInSeconds= $_POST['time'];

    $referrer_link = wp_get_referer();

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

    if (!empty($result)) {
        $lastTimeRecordedInSeconds = seconds_from_time($result[0]->time);
        $lastTimeRecordedInSecond = $lastTimeRecordedInSeconds + $timeSpentOnVideoInSeconds;
        $updatedTime = gmdate("H:i:s", $lastTimeRecordedInSecond);

       $result = $wpdb->update( $table_name,
            [
                'user_id' => $user_id,
                'video_title' => $video_title,
                'date' => $today,
                'time' => $updatedTime,
                'session_ID' => $session_id,
                'update_count' => $result[0]->update_count + 1,
                'site_url' => $referrer_link
            ],
            [
                'user_id' => $user_id,
                'date' => $today,
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
                'time' => gmdate("H:i:s", $timeSpentOnVideoInSeconds),
                'session_ID' => $session_id,
                'update_count' => 1,
                'site_url' => $referrer_link
            ],
        );
    }

    wp_die();

}

add_action('wp_ajax_time_spent_on_vid', 'essense_partners_update_video_percentage_table' );


