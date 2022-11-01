<?php

if (!function_exists('array_key_ulast')) {
function array_key_ulast(iterable $array, callable $callback = null, $default = null) {
	if (null === $callback) {
		return count($array) ? end(array_keys($array)) : mixedval($default);
	}

	return array_key_ufirst(array_reverse($array, true), $callback, $default);
}
}
