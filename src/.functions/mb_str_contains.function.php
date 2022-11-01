<?php

if (!function_exists('mb_str_contains')) {
if (!function_exists('mb_str_contains')) {
    function mb_str_contains( $haystack, $needle, String $encoding = null ) {
		if (is_null($encoding)) $encoding = mb_internal_encoding() ?: "UTF-8";
        return $needle !== '' && mb_strpos($haystack, $needle, 0, $encoding) !== false;
    }
}
}
