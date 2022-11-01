<?php

if (!function_exists('http_redirect')) {
function http_redirect(String $location, Int $status_code = 303) {
	if ($status_code < 300 || $status_code > 399) {
		_trigger_error("Non-3xx HTTP Redirect Code $status_code, mapping to 303", E_USER_WARNING, 1);
		$status_code = 303;
	}
	
	if (mb_str_starts_with($location, '//'))
		$location = (is_ssl() ? 'https:' : 'http:').$location;

	header("Location: $location", true, $status_code);
	http_exit($status_code);
}
}
