<?php

if (!function_exists('uuidgen')) {


/**
 * UUID Gen
 *
 * Generates a UUIDv4 string.
 *
 * Allows insecure, yet fast, MT Rand generation, as well as preferential use
 * of either '/proc/sys/kernel/random/uuid' or `openssl_random_pseudo_bytes()`.
 * In the event that $strong is greater than 0 and either is missing, it will
 * use the other (possibly incurring wall-time). Both are "Cryptographically
 * Secure," just '/proc/sys/kernel/random/uuid' in trully random, whereas SSL
 * is pseudo-random.
 *
 * As mentioned, both are highly secure, this feature is only avaialble to allow
 * use of a faster algorithm, either for performance or fallback purposes.
 *
 * Note: It is possible, in extreem cases, to exhaust the Entropy Pool, causing
 * the Kernel-based UUID generator to block. This is not predictable. However
 * the additional wall time will be insignificant.
 * 
 * @param int $strength Require strong randomness, and preference of source.
 * 
 * @return string UUIDv4 String 
 * 
 * @throws \Exception Unable to find a sutable source for UUID generation.
 *
 * @author Mike Mulligan <michael@bigroomstudios.com>
 */
function uuidgen($strength = 2) {
	
	if ($strength < 1) {
		// Least Secure, Fastest - Approx 11us per call.
		
		$uuid = sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
			// 32 bits for "time_low"
			mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ),
	
			// 16 bits for "time_mid"
			mt_rand( 0, 0xffff ),
	
			// 16 bits for "time_hi_and_version",
			// four most significant bits holds version number 4
			mt_rand( 0, 0x0fff ) | 0x4000,
	
			// 16 bits, 8 bits for "clk_seq_hi_res",
			// 8 bits for "clk_seq_low",
			// two most significant bits holds zero and one for variant DCE1.1
			mt_rand( 0, 0x3fff ) | 0x8000,
	
			// 48 bits for "node"
			mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff )
		);
	} elseif (function_exists('openssl_random_pseudo_bytes') &&
			  ($strength == 1 || !is_readable('/proc/sys/kernel/random/uuid')) &&
			   strlen($bytes = openssl_random_pseudo_bytes(16)) == 16) {
		// Secure, Fast - Approx 15us per call
		
		$bytes[6] = chr(ord($bytes[6]) & 0x0f | 0x40); // set version to 0100
		$bytes[8] = chr(ord($bytes[8]) & 0x3f | 0x80); // set bits 6-7 to 104
		$uuid = vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($bytes), 4));
	} elseif(is_readable('/proc/sys/kernel/random/uuid')) {
		// Most Secure, Slowest - Approx 25-50us per call
		
		$uuid = file_get_contents('/proc/sys/kernel/random/uuid');
	}
	
	if(empty($uuid)) {
		throw new \Exception('Unable to find a sutable source for UUID generation.');
	}
	
	return trim($uuid);
}
}
