<?php

if (!function_exists('sort_compare')) {
function sort_compare($a, $b) {
	if($a === $b) return 0;
	if (is_null($a) || is_null($b)) return is_null($b) ? -1 : 1;
	return ($a < $b) ? -1 : 1;
}
}
