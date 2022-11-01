<?php

if (!function_exists('is_ssl')) {
/**
 * SSL Check
 */
function is_ssl() {
	static $is_ssl = null;

	if (is_null($is_ssl))
		$is_ssl = (!empty($_SERVER['HTTPS']) && (('1' == $_SERVER['HTTPS']) || strcasecmp('on', $_SERVER['HTTPS'])))
			|| (!empty($_SERVER['REQUEST_SCHEME']) && strcasecmp('https', $_SERVER['REQUEST_SCHEME']))
			|| (!empty($_SERVER['HTTP_X_FORWARDED_PROTO']) && strcasecmp('https', $_SERVER['HTTP_X_FORWARDED_PROTO']))
			|| (!empty($_SERVER['SERVER_PORT']) && ('443' == $_SERVER['SERVER_PORT']))
			|| (!empty($_SERVER['HTTP_X_FORWARDED_SSL']) && (('1' == $_SERVER['HTTP_X_FORWARDED_SSL']) || strcasecmp('on', $_SERVER['HTTP_X_FORWARDED_SSL'])));

	return $is_ssl;

}
}
