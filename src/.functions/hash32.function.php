<?php

if (!function_exists('hash32')) {
/**
 * Performs a simple 32bit (unsigned) hash using Cyclic
 * Redundancy check as the algorithm.
 *
 * @author Michael Bailey
 * @param string $string
 * @return int32
 */
function hash32($string)
{
	return abs(crc32($string));
} // end function hash32
}
