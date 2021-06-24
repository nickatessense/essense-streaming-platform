<?php

/**
 * Updates database analytics_user_page_time_tracker table with time spent on page
 */
function essense_partners_update_user_page_time(){

	global $wpdb;

	$user_id = get_current_user_id();

	$result = $wpdb->insert(
         'analytics_user_page_time_tracker',
        [
            'user_id' => $user_id,
            'page_url' => wp_get_referer(),
            'time_spent_in_seconds' => $_POST['time'],

        ],
    );

	wp_die();

}


add_action('wp_ajax_time_spent_on_page', 'essense_partners_update_user_page_time' );