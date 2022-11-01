<?php

if (!function_exists('sql_time')) {
function sql_time($timestamp){

	$return = date('G:i:s', $timestamp);

	return $return;

}
}
