<?php

if (!function_exists('sql_date_time_from_array')) {
function sql_date_time_from_array($select_array){

	$return = sql_date_from_array($select_array);

	if($select_array['Date_Time']){

		$time = getdate($select_array['Date_Time']);
		$return .= ' ' . sql_time_from_array($time);
	}

	return $return;

}
}
