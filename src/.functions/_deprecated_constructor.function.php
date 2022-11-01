<?php

if (!function_exists('_deprecated_constructor')) {
/**
 * Marks a constructor as deprecated and informs when it has been used.
 *
 * Similar to _deprecated_function(), but with different strings. Used to
 * remove PHP4 style constructors.
 *
 * This function is to be used in every PHP4 style constructor method that is deprecated.
 *
 * @param string $class        The class containing the deprecated constructor.
 * @param string $version      The version that deprecated the function.
 * @param string $parent_class Optional. The parent class calling the deprecated constructor.
 *                             Default empty string.
 */
function _deprecated_constructor( $class, $version = null, $parent_class = null, $offset = 0 ) {

	/**
	 * Fires when a deprecated constructor is called.
	 *
	 * @param string $class        The class containing the deprecated constructor.
	 * @param string $version      The version that deprecated the function.
	 * @param string $parent_class The parent class calling the deprecated constructor.
	 */
	/* do_action( 'deprecated_constructor_run', $class, $version, $parent_class ); */

	/**
	 * Filters whether to trigger an error for deprecated functions.
	 *
	 * @param bool $trigger Whether to trigger the error for deprecated functions. Default true.
	 */
	if ( DEBUG /* && apply_filters( 'deprecated_constructor_trigger_error', true ) */ ) {
		
		// 'The called constructor method for %1$s in %2$s is <strong>deprecated</strong> since version %3$s! Use %4$s instead.'
		$format = 'The called constructor method for %1$s';
		if (!empty($parent_class))
			$format .= ' in %2$s';
		$format .=' <strong>deprecated</strong>';
		if (!empty($version))
			$format .= ' since version %3$s';
		$format .= '! Use %4$s instead.';
		
		if ( function_exists( '__' ) )
			$format = __($format);
		
		_trigger_error( sprintf( $format, $class, $parent_class, $version, '<pre>__construct()</pre>' ), E_USER_DEPRECATED, 2 + max((int) $offset, 0));
		
	}

}
}
