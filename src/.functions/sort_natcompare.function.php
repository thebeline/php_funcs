<?php

if (!function_exists('sort_natcompare')) {
function sort_natcompare($a, $b) {
	if($a === $b) return 0;
	if (is_null($a) || is_null($b)) return is_null($b) ? -1 : 1;
	return strnatcmp($a, $b);
}
}
