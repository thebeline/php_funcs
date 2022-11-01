<?php

if (!function_exists('is_assoc')) {
function is_assoc($array) {
	return (bool) array_usearch((array) $array, function($value, $key) {
		return (bool) is_string($key);
	});
}
}
