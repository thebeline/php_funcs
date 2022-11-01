<?php

if (!function_exists('error_logr')) {
function error_logr(...$args/*$message, $message_type = 0 , $destination, $extra_headers*/) {
	if(!empty($args[0])) $args[0] = print_r($args[0], TRUE);
	if(!empty($args[1]) && $args[1] == 3) {
		try {
			if (!empty($args[2])) {
				$path = pathinfo("{$args[2]}");
				$args[2] = require_directory($path['dirname']).DIR_SEP.$path['basename'];
			}
			if (!file_exists($args[2]))
				touch($args[2]);
			$args[0] = '['.date('Y-m-d H:i:s e', time()).'] '.$args[0] . PHP_EOL;
		} catch (\Exception $e) {
			$args[0] = "Unable to create the parent directory for the log {$args[2]}, write failure predicted.\nMESSAGE: {$args[0]}";
			$args[2] = NULL;
		}
	}
	return error_log(...$args);
}
}
