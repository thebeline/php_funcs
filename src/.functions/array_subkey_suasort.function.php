<?php

if (!function_exists('array_subkey_suasort')) {
function array_subkey_suasort(&$array, $key, $callback = 'sort_natcompare') {
	return suasort($array, function ($a, $b) use ($callback, $key) {
		return $callback(
			isset($a[$key]) ? $a[$key] : NULL,
			isset($b[$key]) ? $b[$key] : NULL
		);
	});
}
}
