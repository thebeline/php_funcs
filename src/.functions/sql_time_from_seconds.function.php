<?php

if (!function_exists('sql_time_from_seconds')) {


function sql_time_from_seconds($seconds){

	$base_time = mktime(0,0,0,6,17,1979);

	$seconds += $base_time;

	$sql_time = sql_time($seconds);

	return $sql_time;
}
}
