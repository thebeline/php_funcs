<?php

if (!function_exists('array_key_ufirst')) {
/**
 * Return the first element in an array passing a given truth test.
 *
 * @see Arr::first() https://github.com/illuminate/support
 *
 * @param array         $array    Haystack array
 * @param null|callable $callback Optional callback function
 * @param mixed         $default  Default value if array element not found
 *
 * @return mixed
 */
function array_key_ufirst(iterable $array, callable $callback = null, $default = null) {
	if (null === $callback) {
		return count($array) ? array_keys($array)[0] : mixedval($default);
	}

	$key = array_usearch($array, $callback, $found);
	
	return $found ? $key : mixedval($default);
}
}
