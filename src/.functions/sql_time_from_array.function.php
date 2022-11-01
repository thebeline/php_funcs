<?php

if (!function_exists('sql_time_from_array')) {
function sql_time_from_array($time){

	$return = sprintf("%02d:%02d:%02d", $time['hours'], $time['minutes'], $time['seconds']);

	return $return;

}
}
