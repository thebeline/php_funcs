<?php

if (!function_exists('_deprecated_function')) {
/**
 * Mark a function as deprecated and inform when it has been used.
 *
 * There is a {@see 'hook deprecated_function_run'} that will be called that can be used
 * to get the backtrace up to what file and function called the deprecated
 * function.
 *
 * This function is to be used in every function that is deprecated.
 *
 * @param string $function    The function that was called.
 * @param string $version     The version that deprecated the function.
 * @param string $replacement Optional. The function that should have been called. Default null.
 */
function _deprecated_function( $function, $version = null, $replacement = null, $offset = 0 ) {
	
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
		
		$format = '%1$s is <strong>deprecated</strong>';
		if (!empty($version))
			$format .= ' since version %2$s';
		$format .='!';
		if (!empty($replacement))
			$format .= ' Use %3$s instead.';
		
		if ( function_exists( '__' ) )
			$format = __($format);
		
		_trigger_error( sprintf( $format, $function, $version, $replacement ), E_USER_DEPRECATED , 2 + max((int) $offset, 0));
		
	}
}
}
