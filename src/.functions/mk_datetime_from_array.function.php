<?php

if (!function_exists('mk_datetime_from_array')) {
function mk_datetime_from_array($date_array, $time = null){

	if($time){
		$time = getdate($time);
		$return = mktime($time['hours'],$time['minutes'],$time['seconds'],$date_array['Date_Month'],$date_array['Date_Day'],$date_array['Date_Year']);
	}else{
		$return = mktime(0,0,0,$date_array['Date_Month'],$date_array['Date_Day'],$date_array['Date_Year']);
	}
	return $return;

}
}
