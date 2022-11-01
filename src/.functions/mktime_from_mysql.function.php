<?php

if (!function_exists('mktime_from_mysql')) {

function mktime_from_mysql($mysql_time){

	if($mysql_time == '0000-00-00' || $mysql_time == '0000-00-00 00:00:00'){

		return null;

	}else{

		$year = substr($mysql_time, 0, 4);
		$month = substr($mysql_time, 5, 2);
		$day = substr($mysql_time, 8, 2);
		$hours = substr($mysql_time, 11, 2);
		$minutes = substr($mysql_time, 14, 2);
		$seconds = substr($mysql_time, 17, 2);

		$time = mktime($hours,$minutes,$seconds,$month,$day,$year);

		return $time;
	}
}
}
