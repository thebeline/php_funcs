<?php

if (!function_exists('random_bytes')) {
	/**
     * Random Bytes 
     *
     * Simple polyfill for PHP 7's `random_bytes()`
     *
     * @param int $length Number of Bytes to get
     * 
     * @return binary Random bytes 
     *
     * @author Michael Mulligan <mike@belineperspectives.com>
     */
	function random_bytes($length) {
		if (function_exists('mcrypt_create_iv')) {
			return mcrypt_create_iv($length, MCRYPT_DEV_URANDOM);
		} 
		if (function_exists('openssl_random_pseudo_bytes')) {
			return openssl_random_pseudo_bytes($length);
		}
		
		if (is_readable('/dev/urandom') &&
		    ($fh = @fopen('/dev/urandom', 'rb'))) {
			$output = fread($fh, $length);
			fclose($fh);
			return $output;
		}
	}
}