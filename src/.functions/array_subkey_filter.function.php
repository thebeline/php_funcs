<?php

if (!function_exists('array_subkey_filter')) {
function array_subkey_filter(&$array, $key, $callback = 'boolval') {
	return array_filter($array, function ($item) use ($callback, $key) {
		return $callback(isset($item[$key]) ? $item[$key] : NULL);
	});
}
}
