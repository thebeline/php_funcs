<?php

if (!function_exists('round_to_penny')) {
/**
 * Round To Penny 
 *
 * Round a number like 123.456 to 123.46
 *
 * @todo Likely doesn't handle numbers with thousands separators, or different decimal separators well...  Should look in to that.
 *
 * @param string|int|float $amount Dollar value to round
 * 
 * @return string Rounded value
 *
 * @author Michael Mulligan <mike@belineperspectives.com>
 */
function round_to_penny($amount){
	return fround($amount, 2);
}
}
