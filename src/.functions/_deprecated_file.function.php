<?php

if (!function_exists('_deprecated_file')) {
/**
 * Mark a file as deprecated and inform when it has been used.
 *
 * There is a hook {@see 'deprecated_file_included'} that will be called that can be used
 * to get the backtrace up to what file and function included the deprecated
 * file.
 *
 * This function is to be used in every file that is deprecated.
 *
 * @param string $file        The file that was included.
 * @param string $version     The version that deprecated the file.
 * @param string $replacement Optional. The file that should have been included based on ABSPATH.
 *                            Default null.
 * @param string $message     Optional. A message regarding the change. Default empty.
 */
function _deprecated_file( $file, $version = null, $replacement = null, $message = '', $offset = 0 ) {

	/**
	 * Fires when a deprecated file is called.
	 *
	 * @param string $file        The file that was called.
	 * @param string $replacement The file that should have been included based on ABSPATH.
	 * @param string $version     The version that deprecated the file.
	 * @param string $message     A message regarding the change.
	 */
	/* do_action( 'deprecated_file_included', $file, $replacement, $version, $message ); */

	/**
	 * Filters whether to trigger an error for deprecated files.
	 *
	 * @param bool $trigger Whether to trigger the error for deprecated files. Default true.
	 */
	if ( DEBUG /* && apply_filters( 'deprecated_file_trigger_error', true ) */ ) {
		
		// '%1$s is <strong>deprecated</strong> since version %2$s! Use %3$s instead.'
		$format = '%1$s is <strong>deprecated</strong>';
		if (!empty($version))
			$format .= ' since version %2$s';
		if (!empty($replacement))
			$format .= '!  Use %3$s instead.';
		else
			$format .= ' with no alternative available.';
		
		if ( function_exists( '__' ) )
			$format = __($format);
		
		$message = empty( $message ) ? '' : ' ' . $message;
		
		_trigger_error( sprintf( $format, $file, $version, $replacement ).$message, E_USER_DEPRECATED , 2 + max((int) $offset, 0));
		
	}
}
}
