<?php

if (!function_exists('friendly_backtrace')) {
/**
 * Friendly Backtrace
 *
 * Provides a nice and clean formatted Backtrace String for use in `error_log()`
 * or similair for debugging.
 *
 * @param int $max The maximum number of Backtrace steps to take.
 *
 * @return string Formatted Backtrace
 *
 * @author Michael Mulligan <mulligan@bigroomstudios.com>
 */
function friendly_backtrace($max = 1, $offset = 0){
	$traces = debug_backtrace_offset((max((int) $offset, 0) + 1), $max);
	$_pad = strlen($max);
	
    foreach($traces as $i => &$trace) {
		$trace = ($max > 1 ? (str_pad($i, $_pad, ' ', STR_PAD_LEFT).'. ') : '').debug_get_trace_string($trace);
	}
	unset($trace);
	
    return implode(PHP_EOL, $traces);

}
}
