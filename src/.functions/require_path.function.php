<?php

if (!function_exists('require_path')) {
function require_path($path, $respect = FALSE) {
	$path = pathinfo("$path");
	$dir  = require_directory($path['dirname'], $respect);
	$path = $dir.DIR_SEP.$path['basename'];
	if(!is_file($path)) {
		throw new \Exception('Unable to make required path: '.$path);
	}
	return (string) $path;
}
}
