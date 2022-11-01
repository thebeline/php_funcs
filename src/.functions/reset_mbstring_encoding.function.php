<?php

if (!function_exists('reset_mbstring_encoding')) {
function reset_mbstring_encoding() {
    mbstring_binary_safe_encoding( true );
}
}
