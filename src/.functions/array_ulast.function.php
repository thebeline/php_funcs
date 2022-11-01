<?php

if (!function_exists('array_ulast')) {
function array_ulast(iterable $array, callable $callback = null, $default = null) {
	return $array[array_key_ulast($array, $callback, $default)] ?: null;
}
}
