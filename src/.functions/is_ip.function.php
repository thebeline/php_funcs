<?php

if (!function_exists('is_ip')) {
/**
 * Check if the input is a valid IP address. Recognizes both IPv4 and IPv6 addresses.
 *
 * @see IP::isValid() https://github.com/layershifter/TLDSupport
 *
 * @param string $hostname Hostname that will be checked
 *
 * @return boolean
 */
function is_ip($hostname) {
	$hostname = trim($hostname);

	// Strip the wrapping square brackets from IPv6 addresses.

	if (mb_str_starts_with($hostname, '[') && mb_str_ends_with($hostname, ']')) {
		$hostname = substr($hostname, 1, -1);
	}

	return (bool)filter_var($hostname, FILTER_VALIDATE_IP);
}
}
