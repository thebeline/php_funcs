<?php

if (!function_exists('sql_date')) {
function sql_date($timestamp){

	$return = date('Y-m-d', $timestamp);

	return $return;

}
}
