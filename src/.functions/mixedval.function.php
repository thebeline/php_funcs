<?php

if (!function_exists('mixedval')) {

/**
 * Return the default value of the given value.
 *
 * @see Mixed::value() https://github.com/illuminate/support
 *
 * @param mixed $value
 * @param mixed $default
 *
 * @return mixed
 */
function mixedval($value, $default = null) {
	if (!isset($value)) {
		if (!isset($default)) {
			return null;
		}
		$value = $default;
	}
	return $value instanceof \Closure ? $value() : $value;
}
}
