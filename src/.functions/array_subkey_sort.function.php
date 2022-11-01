<?php

if (!function_exists('array_subkey_sort')) {
function array_subkey_sort(&$array, $key) {
	return array_subkey_suasort($array, $key, 'sort_natcompare');
}
}
