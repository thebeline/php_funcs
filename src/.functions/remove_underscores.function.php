<?php

if (!function_exists('remove_underscores')) {
function remove_underscores($string){

	//$return = urldecode($string);
	//$return = html_entity_decode($string);
	return strtotitle(str_replace('_', ' ', str_replace('_and_', '&', $string)));
}
}
