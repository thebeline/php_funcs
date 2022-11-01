<?php

if (!function_exists('cli_expand_path')) {
function cli_expand_path($path) {
	if(strpos($path, '~') === 0) {
		$path = $_SERVER['HOME'].DIR_SEP.substr($path, 1);
	} elseif (strpos($path, '/') !== 0) {
		$path = $_SERVER['PWD'].DIR_SEP.$path;
	}
	return $path;
}
}
