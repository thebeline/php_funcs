<?php

if (!function_exists('sql_date_from_array')) {
function sql_date_from_array($select_array){

	if( isset($select_array['Date_Day']) ){

		$return =  sprintf("%04d-%02d-%02d", $select_array['Date_Year'], $select_array['Date_Month'], $select_array['Date_Day']);

	}else{

		$return =  sprintf("%04d-%02d-01", $select_array['Date_Year'], $select_array['Date_Month']);
	}

	return $return;

}
}
