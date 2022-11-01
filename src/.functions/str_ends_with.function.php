<?php

if (!function_exists('str_ends_with')) {
if (!function_exists('str_ends_with')) {
    function str_ends_with( $haystack, $needle ) {
        if ( '' === $haystack && '' !== $needle ) {
            return false;
        }
        $len = strlen( $needle );
        return 0 === substr_compare( $haystack, $needle, -$len, $len );
    }
}
}
