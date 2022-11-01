<?php

if (!function_exists('safeurl_to_string')) {
function safeURL_to_string($return){

    $return = str_replace('-slash-', '/', $return);
    $return = str_replace('-and-', '&', $return);
    $return = str_replace('_', ' ', $return);

    return $return;
}
}
