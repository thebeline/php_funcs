<?php

if (!function_exists('get_ip')) {
function get_ip($ip = NULL) {
	static $this_ip = NULL;
	
	if(empty($ip)) {
		if($this_ip === NULL) {
			if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
				$this_ip = $_SERVER['HTTP_CLIENT_IP'];
			} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
				$this_ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
			} elseif(!empty($_SERVER['REMOTE_ADDR'])) {
				$this_ip = $_SERVER['REMOTE_ADDR'];
			} else {
				$this_ip = '';
			}
		}
		$ip = $this_ip;
	}
	
	return preg_match("/^([0-9]{1,3}\\.[0-9]{1,3}\\.[0-9]{1,3}\\.[0-9]{1,3})/", $ip, $m) ? $m[1] : NULL;
}
}
