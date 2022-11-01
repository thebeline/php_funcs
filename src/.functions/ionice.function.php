<?php

if (!function_exists('ionice')) {
function ionice(Int &$level = null, Int &$class = null, Int &$pid = null) {
	if (is_null($pid))
		$pid = getmypid();
	
	$return = true;

	list($old_class, $old_level) = explode(': prio ', exec("ionice -p $pid"));
	
	$old_class = ((int) $old_class >= 3) ? 3 : 2;
	$old_level = max(min((int) $old_level, 7), 0);
	
	if (isset($level)) {
		
		$new_level = max(min((int) $level, 7), 0);
		$new_class = $class;

		if (is_null($new_class))
			$new_class = $old_class;
		
		$new_class = ((int) $new_class >= 3) ? 3 : 2;
		
		exec("ionice -c $new_class -n $new_level -p $pid", $o, $r);
		
		$return = empty($r);
	}
	
	if ($return) {
		$level = $old_level;
		$class = $old_class;
	}

	return $return;
}
}
