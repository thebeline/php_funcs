<?php

if (!function_exists('suasort')) {
function suasort(array &$array, $value_compare_func) {
	if(!is_callable($value_compare_func)) {
		trigger_error('Argument 2 passed to suasort() must be callable.', E_USER_ERROR);
	}
	$index = 0;
	foreach ($array as &$item) {
		$item = array($index++, $item);
	}
	$result = uasort($array, function($a, $b) use($value_compare_func) {					
		$result = $value_compare_func($a[1], $b[1]);
		return $result == 0 ? $a[0] - $b[0] : $result;
	});
	foreach ($array as &$item) {
		$item = $item[1];
	}
	return $result;
}
}
