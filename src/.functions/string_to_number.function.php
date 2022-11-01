<?php

if (!function_exists('string_to_number')) {

function string_to_number($string){

	if(is_numeric($string) || empty($string)){

		return 	$string;

	}else{

		$str = (string)$string;

		$il = strlen($str);
		$flt = "";
		$cstr = "";

		for($i=0;$i<$il;$i++) {
		   $cstr = substr($str, $i, 1);
		   if(is_numeric($cstr) || $cstr == ".")
			   $flt = $flt.$cstr;
		}

		return floatval($flt);
	}
}
}
