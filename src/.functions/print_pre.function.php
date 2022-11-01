<?php

if (!function_exists('print_pre')) {
function print_pre($array, $return = null){
	return print_r("<pre>\n".print_r($array, true)."\n</pre>\n", $return);
}
}
