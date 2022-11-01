<?php

if (!function_exists('mb_str_starts_with')) {
if (!function_exists('mb_str_starts_with')) {
    function mb_str_starts_with( $haystack, $needle, String $encoding = null ) {
		if (is_null($encoding)) $encoding = mb_internal_encoding() ?: "UTF-8";
        return ($needle !== '' && mb_strpos($haystack, $needle, 0, $encoding) === 0);
    }
}
}
