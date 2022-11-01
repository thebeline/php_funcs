<?php

if (!function_exists('file_cached')) {
function &file_cached($group, $name, $callback, Array $params = array(), $rebuild_mtime = MTIME) {
	static $memory_cache = array();
	$group = "$group";
	$name  = "$name";
	if(!isset($memory_cache[$group][$name])) {
		$cache_file  = require_directory(PATH_CACHE.DIR_SEP);
		$cache_file .= urlencode($group).'.';
		$cache_file .= urlencode($name).'.cache';
		
		$rebuild = !file_exists($cache_file) || (filemtime($cache_file) < $rebuild_mtime) || !filesize($cache_file);
		$rebuild = $rebuild || (APP_ENV == 'dev');
		$lock_ex = FALSE;
		
		if ($pointer = fopen($cache_file, "c+")) {
			
			if ($rebuild) {
				
				//print_pre(array('trying rebuild',$cache_file));
				
				$was_blocking = FALSE;
				$lock_ex = flock($pointer, LOCK_EX | LOCK_NB, $was_blocking) || ($was_blocking && flock($pointer, LOCK_EX));
				if ($was_blocking && (filemtime($cache_file) > $rebuild_mtime)) {
					flock($pointer, LOCK_UN);
					$rebuild = $lock_ex = FALSE;
				}
			}
			
			if (!$rebuild) {
				
				//print_pre(array('reading', $cache_file));
				
				if (flock($pointer, LOCK_SH)) {
					
					$data = fread($pointer, filesize($cache_file));
					flock($pointer, LOCK_UN);
					
				//print_pre(array('got lock', $cache_file, $data));
					
					if ($data) $memory_cache[$group][$name] = unserialize($data);
					else error_log("Unable to read from cache file, returned empty string: $cache_file");
					
				} else error_log("Unable to obtain shared lock on cache file: $cache_file");
				
			}
			
		} else error_log("Unable to open cache file for reading or writing: $cache_file");
		
		if (!isset($memory_cache[$group][$name])) {
			
				//print_pre(array('no read', $cache_file));
			
			$memory_cache[$group][$name] = call_user_func_array($callback, $params);
			
			if($lock_ex) {
				
				//print_pre(array('writing', $cache_file, $memory_cache[$group][$name]));
				
				if (!(
					ftruncate($pointer, 0) &&
					fwrite($pointer, serialize($memory_cache[$group][$name])) &&
					fflush($pointer) &&
					touch($cache_file)
				)) error_log("Unable to write to cache file: $cache_file");
				
				flock($pointer, LOCK_UN);
			}
			
		}
		
		if ($pointer) fclose($pointer);
		
	}
	
	return $memory_cache[$group][$name];
}
}
