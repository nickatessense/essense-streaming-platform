<?php

/**
 * Internal Function to convert time from format H:i:s (00:00:00) to seconds
 */
function seconds_from_time($time) {
    list($h, $m, $s) = explode(':', $time);
    return ($h * 3600) + ($m * 60) + $s;
}

/**
 * Note: function copied from admin/includes/upgrade.php
 * Did not want to include entire upgrade file.
 * Creates a table in the database, if it doesn't already exist.
 *
 * This method checks for an existing database and creates a new one if it's not
 * already present. It doesn't rely on MySQL's "IF NOT EXISTS" statement, but chooses
 * to query all tables first and then run the SQL statement creating the table.
 *
 * @since 1.0.0
 *
 * @global wpdb $wpdb WordPress database abstraction object.
 *
 * @param string $table_name Database table name.
 * @param string $create_ddl SQL statement to create table.
 * @return bool True on success or if the table already exists. False on failure.
 */
function maybe_create_table( $table_name, $create_ddl ) {
    global $wpdb;

    $query = $wpdb->prepare( 'SHOW TABLES LIKE %s', $wpdb->esc_like( $table_name ) );

    if ( $wpdb->get_var( $query ) === $table_name ) {
        return true;
    }

    // Didn't find it, so try to create it.
    $wpdb->query( $create_ddl );

    // We cannot directly tell that whether this succeeded!
    if ( $wpdb->get_var( $query ) === $table_name ) {
        return true;
    }

    return false;
}