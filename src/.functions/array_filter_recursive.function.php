<?php

if (!function_exists('array_filter_recursive')) {
function array_filter_recursive($input, $callback = null) {
	if (empty($callback))
		$callback = function($value) { return !empty($value); };
	foreach ($input as &$value) { 
		if (is_array($value)) { 
			$value = array_filter_recursive($value, $callback); 
		} 
	} 
	return array_filter($input, $callback); 
} 
}
