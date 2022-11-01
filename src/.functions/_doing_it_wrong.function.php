<?php

if (!function_exists('_doing_it_wrong')) {
/**
 * Mark a thing as wrong.
 *
 * @param string $function    The function that was called.
 * @param string $version     The version that deprecated the function.
 * @param string $replacement Optional. The function that should have been called. Default null.
 */
function _doing_it_wrong( $thing, $alternative = null, $offset = 0 ) {
	
	/**
	 * Fires when a deprecated function is called.
	 *
	 * @param string $function    The function that was called.
	 * @param string $replacement The function that should have been called.
	 * @param string $version     The version of WordPress that deprecated the function.
	 */
	/* do_action( 'deprecated_function_run', $function, $replacement, $version ); */

	/**
	 * Filters whether to trigger an error for deprecated functions.
	 *
	 * @param bool $trigger Whether to trigger the error for deprecated functions. Default true.
	 */
	if ( DEBUG /* && apply_filters( 'deprecated_function_trigger_error', true ) */ ) {
		
		$format = '%1$s is <strong>doing it wrong</strong>!';
		if (!empty($alternative))
			$format .= ' Maybe try %2$s instead.';
		
		if ( function_exists( '__' ) )
			$format = __($format);
		
		_trigger_error( sprintf( $format, $thing, $alternative ), E_USER_WARNING , 2 + max((int) $offset, 0));
		
	}
}
}
