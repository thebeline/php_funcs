<?php

if (!function_exists('priceformat')) {
function priceFormat($var,$format = '%.2n',$locale = "en_US") {

    $var = str_replace(array(" ","$","€",","), "", $var);

	$number = floatval($var);

	setlocale(LC_MONETARY, $locale);

	return money_format($format, $number);

}
}
