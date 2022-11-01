<?php

if (!function_exists('nicearray')) {
/**
 * Convert Unknown Type to Array with Max Depth
 *
 * Helper to convert Objects or Arrays to Arrays that are only $max deep.
 *
 * Now supports just outputting byte-size, as well as printing the full
 * path.
 *
 * @author	Michael Mulligan
 *
 * @param	mixed	$data	The Data to convert to a descriptive Array
 * @param	int		$max	The number of levels deep to traverse into $data
 * 
 * @return	Array
 */
function niceArray($data, $max_depth = 2, $just_bytes = FALSE, $print_path = FALSE, $path = null) {
	static $current = 0;
	
	$type = gettype($data);
	
	if(empty($path) && $print_path) {
		$path = '$'.strtolower(str_replace(' ', '_', $type));
	}
	
	// Push us up a level.
	$current++;
	
	switch($type) {
		case 'array':
		case 'object':
			if($current > $max_depth) {
				/**
				 * If we are at our maximum depth, we do not recurse into the item,
				 * simply indicate if it is empty or not.
				 */
				$return = ucfirst($type).'( '.((empty($data)) ? 'no' : count((array) $data)).' nodes)';
			} else {
				
				$return = array();
				
				$is_obj = is_object($data);
				
				foreach((array) $data as $key => $object) {
					$next_path = $is_obj ? $path.'->'.$key : $path.'[\''.$key.'\']';
					// Recursively call ourself on the items to get their contents.
					// This DOES introduce a memory leak (temporary) for large objects with large $max_depth
					$return['{'.gettype($object).'}'.$key] = call_user_func(__FUNCTION__, $object, $max_depth, $just_bytes, $print_path, $next_path);
				}
			}
			break;
		case 'integer':
		case 'double':
			$return = $data;
			break;
		case 'boolean':
			$return = ($data) ? 'TRUE' : 'FALSE';
			break;
		case 'NULL':
			$return = $type;
			break;
		default:
			$return = ($just_bytes) ? strtoupper($type).' ( '.mb_strlen($data).' bytes )' : $data;
			break;
	}
	
	// Back us out a level.
	$current--;

	if($print_path) {
		if(!is_array($return)) {
			return print_r("$path :: $return\n");
		} else {
			// Not at an end-node, so don't print.  Always return true.  :-)
			return TRUE;
		}
	} else {
		return $return;
	}
}
}
