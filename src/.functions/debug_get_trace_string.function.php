<?php

if (!function_exists('debug_get_trace_string')) {
function debug_get_trace_string(Array $trace) {
	$trace_string = '';
	if (!empty($trace['function'])) {
		if (!empty($trace['class']))
			$trace_string .= $trace['class'] .(!empty($trace['type']) ? $trace['type'] : '::');
		$trace_string .= $trace['function'].'() ';
	}
	if (isset($trace['file'])) {
		$trace_string .= $trace['file'];
	}
	if (isset($trace['line']))
		$trace_string .= ":{$trace['line']}";
	
	return $trace_string;
}
}
