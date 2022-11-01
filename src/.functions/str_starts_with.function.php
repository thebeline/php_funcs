<?php

if (!function_exists('str_starts_with')) {
if (!function_exists('str_starts_with')) {
    function str_starts_with( $haystack, $needle ) {
        return strpos( $haystack , $needle ) === 0;
    }
}
}
