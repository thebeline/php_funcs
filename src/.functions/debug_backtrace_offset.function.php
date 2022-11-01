<?php

if (!function_exists('debug_backtrace_offset')) {
function debug_backtrace_offset($offset = 0, $max = 1, $caller_shift = 1) {
	static $root_length = NULL;
	if (is_null($root_length)) {
		$root_length = strlen(realpath(PATH_ROOT));
	}
	
	$offset       = max((int) $offset, 0) + 1;
	$max          = max((int) $max, 0);
	$caller_shift = max((int) $caller_shift, 0);
    	
    $traces = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, $max + $offset + $caller_shift);
	
	while ($offset-- > 0 && (count($traces) > $caller_shift))
		array_shift($traces);
	
	foreach ($traces as $i => $trace) {
		$traces[$i] = [
			'file'     => isset($trace['file']) ? $trace['file'] : substr($trace['file'], $root_length),
			'line'     => isset($trace['line']) ? $trace['line'] : null,
			'function' => isset($traces[$i+$caller_shift]['function']) ? $traces[$i+$caller_shift]['function'] : null,
			'class'    => isset($traces[$i+$caller_shift]['class'])    ? $traces[$i+$caller_shift]['class']    : null,
			'type'     => isset($traces[$i+$caller_shift]['type'])     ? $traces[$i+$caller_shift]['type']   : null,
		];
		if (($i + $caller_shift) > $max)
			break;
	}
	
	if (count($traces) > $max)
		while ($caller_shift-- > 0 && count($traces) > 1)
			array_pop($traces);
	
	return $traces;
	
}
}
