<?php

if (!function_exists('array_set_current')) {
//set the pointer of an array to the given key
function array_set_current(&$array, $key){

	reset($array);

	while (
		(($_key = key($array)) !== NULL)
		&& ($_key != $key)
	) next($array);
	
	return isset($_key);

}
}
