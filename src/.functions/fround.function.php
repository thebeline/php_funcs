<?php

if (!function_exists('fround')) {
define('PHP_ROUND_UP',   11);
define('PHP_ROUND_DOWN', 12);
function fround($number, $precision = 0, $mode = PHP_ROUND_HALF_UP) {
	if (is_numeric($number)) {
		switch($mode) {
			case PHP_ROUND_UP:
			case PHP_ROUND_DOWN:
				if (empty($number)) // Is zero
					break;
				if (!empty($precision)) {
					$precision = pow(10, (int) $precision);
					$number *= $precision;
				}
				// One or the other, but not both
				if (($mode == PHP_ROUND_UP) xor ($number < 0)) {
					$number = ceil($number);
				} else {
					$number = floor($number);
				}
				if (!empty($precision) && !empty($number)) {
					$number /= $precision;
				}
				break;
			default:
				$number = round($number, $precision, $mode);
				break;
		}
		if ($precision > 0) {
			$number = sprintf('%0.'.((int) $precision).'f', $number);
		}
	}
	return $number;
}
}
