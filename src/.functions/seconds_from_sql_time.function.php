<?php

if (!function_exists('seconds_from_sql_time')) {
function seconds_from_sql_time($mysql_time){

	if($mysql_time == '00:00:00'){

		return null;

	}else{

		$hours = substr($mysql_time, 11, 2);
		$minutes = substr($mysql_time, 14, 2);
		$seconds = substr($mysql_time, 17, 2);

		$time = mktime($hours,$minutes,$seconds,6,17,1979);

		$time = $time % 86400;

		return $time;
	}
}
}
