<?php

if (!function_exists('xmlsafevalue')) {
function XMLSafeValue($str) {
	return !empty($str) ? htmlspecialchars(sanitize_for_xml($str), ENT_COMPAT, 'utf-8') : '';
}  
}
