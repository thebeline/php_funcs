<?php

if (!function_exists('_tick_line')) {
// USE: declare(ticks=1); register_tick_function('_tick_line');
function _tick_line() {
	static $ticks = 0;
	error_log('Tick'.($ticks++).': '.friendly_backtrace(1));
}
}
