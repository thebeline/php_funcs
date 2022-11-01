<?php

if (!function_exists('caption_display_field')) {
function caption_display_field($val, $key, $fields) {
	return (empty($fields) || (!isset($fields['none']) && isset($fields[$key])))
		? $val : '';
}
}
