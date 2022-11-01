<?php

if (!function_exists('realpath_str')) {
function realpath_str($path, $relative = FALSE) {
	static $_ds = DIRECTORY_SEPARATOR;
	$path = str_replace(array('/', '\\'), $_ds, $path);
	$prefix = (!$relative || $path[0] === $_ds) ? $_ds : '';
	$parts = array_filter(explode($_ds, $path), 'strlen');
	$absolutes = array();
	foreach ($parts as $part) {
		if ('.' == $part) continue;
		if ('..' == $part && !$relative) {
			array_pop($absolutes);
		} else {
			$absolutes[] = $part;
		}
	}
	return $prefix.implode(DIRECTORY_SEPARATOR, $absolutes);
}
}
