<?php

if (!function_exists('add_underscores')) {
function add_underscores($string){

	$return = $string;

	if (strpos($return, '/') === false) {
		$return = strtolower($return);
	}

	$return = str_replace(' ', '_', $return);
	$return = str_replace('&', '_and_', $return);
	//$return = urlencode($return);

	return $return;
}
}
