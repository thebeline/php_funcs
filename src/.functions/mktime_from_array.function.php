<?php

if (!function_exists('mktime_from_array')) {
//make a unix timestamp based on an array
//works with smarty template function {html_select_date}

function mktime_from_array($select_array){

	//print_pre($select_array);

	if(!$select_array['Date_Day']){
		$select_array['Date_Day'] = 1;
	}

	if($select_array['Date_Month'] && $select_array['Date_Day'] && $select_array['Date_Year']){

		if($select_array['Date_Time']){
			$time = getdate($select_array['Date_Time']);
			$return = mktime($time['hours'],$time['minutes'],$time['seconds'],$select_array['Date_Month'],$select_array['Date_Day'],$select_array['Date_Year']);
		}else{
			$return = mktime(0,0,0,$select_array['Date_Month'],$select_array['Date_Day'],$select_array['Date_Year']);
		}

	}

	//print($return);

	return $return;

}
}
