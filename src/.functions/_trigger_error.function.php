<?php

if (!function_exists('_trigger_error')) {
function _trigger_error($message, $error_type = E_USER_WARNING, $offset = 0) {
	//static $last_message = NULL;
	//static $last_type    = NULL;
	//static $last_count   = NULL;
	
	$location = debug_backtrace_offset(max((int) $offset, 0) + 1);
	
	$location = end($location);
	
	$message .= "\n".($offset < 3 ? 'Reported' : 'Called')." in {$location['file']} on line {$location['line']}"; // in *here*
	
	$status = TRUE;
	
	//if (($last_message == $message) && ($last_type == $error_type)) {
	//	$last_count++;
	//} else {
	//	
	//	if ($last_count) {
	//		trigger_error("$last_message\nPrevious message repeated $last_count times", $last_type);
	//	} else {
	//		$last_count = 0;
	//	}
	//	
	//	$last_message = $message;
	//	$last_type    = $error_type;
		
		$status = trigger_error($message, $error_type);
	//}
	
	return $status;
	
}
}
