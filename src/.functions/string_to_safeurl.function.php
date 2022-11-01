<?php

if (!function_exists('string_to_safeurl')) {
function string_to_safeURL($return){
    
    $return = str_replace(' ', '_', $return);
    $return = str_replace('&', '-and-', $return);
    $return = str_replace('/', '-slash-', $return);

    return $return;
}
}
