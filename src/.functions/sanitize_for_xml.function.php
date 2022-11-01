<?php

if (!function_exists('sanitize_for_xml')) {
/**
 * Removes invalid XML
 *
 * @access public
 * @param string $value
 * @return string
 */
function sanitize_for_xml($input) {
	if (!empty($input)) {
		// Convert input to UTF-8.
		$old_setting = ini_set('mbstring.substitute_character', '"none"');
		$input = mb_convert_encoding($input, 'UTF-8', 'auto');
		ini_set('mbstring.substitute_character', $old_setting);
		
		// Use fast preg_replace. If failure, use slower chr => int => chr conversion.
		$output = preg_replace('/[^\x{0009}\x{000a}\x{000d}\x{0020}-\x{D7FF}\x{E000}-\x{FFFD}]+/u', '', $input);
		if (is_null($output)) {
		  // Convert to ints.
		  // Convert ints back into a string.
		  $output = ords_to_utfstring(utfstring_to_ords($input), TRUE);
		}
	} else {
		$output = $input;
	}
	return $output;
}
}
