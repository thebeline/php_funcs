<?php

if (!function_exists('array_ufirst')) {
function array_ufirst(iterable $array, callable $callback = null, $default = null) {
	return $array[array_key_ufirst($array, $callback, $default)] ?: null;
}
}
