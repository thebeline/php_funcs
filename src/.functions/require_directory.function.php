<?php

if (!function_exists('require_directory')) {
function require_directory($path, $respect_relative = FALSE) {
	$path = (string) $path;
	if(strpos($path, DIR_SEP) !== 0 && !$respect_relative) {
		$path = PATH_ROOT . DIR_SEP . $path;
	}
	if(!is_dir($path) && !mkdir($path, 0777, TRUE)) {
		throw new \Exception('Unable to make required directory: '.$path);
	}
	return (string) $path;
}
}
