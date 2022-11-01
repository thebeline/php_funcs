<?php

if (!function_exists('is_true')) {
// turn user input to a true or false for the DB
function is_true($value) {
	
	$trues = array('yes', 'true', true, '1', 1);

	if (is_string($value)) {
		$value = trim(strtolower($value));
	}
	
	return in_array($value, $trues, TRUE) ? 1 : 0;
	
}
}
