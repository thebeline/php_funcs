<?php

if (!function_exists('mb_str_ends_with')) {
if (!function_exists('mb_str_ends_with')) {
    function mb_str_ends_with( $haystack, $needle, String $encoding = null ) {
		if (is_null($encoding)) $encoding = mb_internal_encoding() ?: "UTF-8";
        return ((string)$needle === mb_substr($haystack, -mb_strlen($needle, $encoding), null, $encoding));
    }
}
}
