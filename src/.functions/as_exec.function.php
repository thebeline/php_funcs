<?php

if (!function_exists('as_exec')) {
function as_exec($command, &$output = NULL, &$return_var = NULL) {
	debug(DEBUG_LOG, 'exec', array($command, $output, $return_var));
	$return = exec($command, $output, $return_var);
	return $return;
}
}
