<?php

if (!function_exists('strip_quotes')) {
function strip_quotes($string){

	if($string){

		$len = strlen($string);

		if($string[0] == '"' && $string[$len-1] == '"'){

			return substr($string, 1, $len-2);

		}else{

			return $string;
		}
	}
}
}
