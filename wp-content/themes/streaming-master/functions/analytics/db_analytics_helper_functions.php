<?php

/**
 * Internal Function to convert time from format H:i:s (00:00:00) to seconds
 */
function seconds_from_time($time) {
    list($h, $m, $s) = explode(':', $time);
    return ($h * 3600) + ($m * 60) + $s;
}