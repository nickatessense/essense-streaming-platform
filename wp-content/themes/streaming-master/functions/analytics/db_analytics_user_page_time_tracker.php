<?php

/**
 * Updates database analytics_user_page_time_tracker table with time spent on page
 */
function essense_partners_update_user_page_time(){

	global $wpdb;

    $table_name = 'analytics_user_page_time_tracker';

    // If table does not exist, create it
    maybe_create_table( $table_name, "
        CREATE TABLE `analytics_user_page_time_tracker` (
            `id` int(11) NOT NULL,
            `user_id` int(11) NOT NULL,
            `page_url` text NOT NULL,
            `time_spent_in_seconds` int(11) NOT NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
    ");

	$user_id = get_current_user_id();

	$result = $wpdb->insert(
         $table_name,
        [
            'user_id' => $user_id,
            'page_url' => wp_get_referer(),
            'time_spent_in_seconds' => $_POST['time'],

        ],
    );

	wp_die();

}

add_action('wp_ajax_time_spent_on_page', 'essense_partners_update_user_page_time' );