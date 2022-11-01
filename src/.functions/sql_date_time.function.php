<?php

if (!function_exists('sql_date_time')) {
function sql_date_time($timestamp){

	$return = sql_date($timestamp) . ' ' . sql_time($timestamp);

	return $return;

}
}
