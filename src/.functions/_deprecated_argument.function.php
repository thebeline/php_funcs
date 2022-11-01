<?php

if (!function_exists('_deprecated_argument')) {
/**
 * Mark a function argument as deprecated and inform when it has been used.
 *
 * This function is to be used whenever a deprecated function argument is used.
 * Before this function is called, the argument must be checked for whether it was
 * used by comparing it to its default value or evaluating whether it is empty.
 * For example:
 *
 *     if ( ! empty( $deprecated ) ) {
 *         _deprecated_argument( __FUNCTION__, '3.0.0' );
 *     }
 *
 *
 * There is a hook deprecated_argument_run that will be called that can be used
 * to get the backtrace up to what file and function used the deprecated
 * argument.
 *
 * @param string $function The function that was called.
 * @param string $version  The version that deprecated the argument used.
 * @param string $message  Optional. A message regarding the change. Default null.
 */
function _deprecated_argument( $function, $version = null, $message = null, $offset = 0) {

	/**
	 * Fires when a deprecated argument is called.
	 *
	 * @param string $function The function that was called.
	 * @param string $message  A message regarding the change.
	 * @param string $version  The version that deprecated the argument used.
	 */
	/* do_action( 'deprecated_argument_run', $function, $message, $version ); */

	/**
	 * Filters whether to trigger an error for deprecated arguments.
	 *
	 * @param bool $trigger Whether to trigger the error for deprecated arguments. Default true.
	 */
	if ( DEBUG /* && apply_filters( 'deprecated_argument_trigger_error', true ) */ ) {
		
		// '%1$s is <strong>deprecated</strong> since version %2$s! Use %3$s instead.'
		$format = '%1$s was called with an argument that is <strong>deprecated</strong>';
		if (!empty($version))
			$format .= ' since version %2$s';
		if (!empty($message))
			$format .= '!  %3$s';
		else
			$format .= ' with no alternative available.';
		
		if ( function_exists( '__' ) )
			$format = __($format);
		
		_trigger_error( sprintf( $format, $function, $version, $message ), E_USER_DEPRECATED, 2 + max((int) $offset, 0));
		
	}
}
}
