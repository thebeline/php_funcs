<?php

if (!function_exists('sanitize_input')) {
function sanitize_input($input, $decode = false){

	static $disallowed_blocks = array(
		'@">\'>@',							// XSS escape string
		'@<head[^>]*?>.*?</head>@si',      // Strip the HEAD block properly
		'@<script[^>]*?>.*?</script>@si',	// Strip out javascript
	/* 	'@<[\/\!]*?[^<>]*?>@si',            // Strip out HTML tags */
		'@<style[^>]*?>.*?</style>@siU',    // Strip style tags properly
		'@<![\s\S]*?--[ \t\n\r]*>@',        // Strip multi-line comments including CDATA
	);
	
	static $allowed_tags =  ['a','b','blockquote','br','em','h1','h2','h3','hr','i','li','ol','p','span','strong','sub','sup','table','tr','td','ul','tbody','code','del','dd','dl','dt','img','kbd','pre','s','strike','font','iframe'];
	
	static $d = 0;
	static $max_d = 10;

	if(!empty($input)) {
		
		if (is_string($input)) {
	
			if ($decode) {
				$input = urldecode($input);
			}
			
			if (TRUE) {
				$input = strip_tags_and_attrs($input, $allowed_tags, TRUE);
			} elseif ($input = preg_replace($disallowed_blocks, '', $input)) {
				// LEFT FOR POSTERITY
				
				if (is_array($allowed_tags)) {
					$allowed_tags = '<'.implode('><', $allowed_tags).'>';
				}
				
				$input = strip_tags($input, $allowed_tags);
				
			}
			
		} elseif (is_array($input) && ($d < $max_d)) {
			$d++;
			foreach ($input as &$value)
				$value = sanitize_input($value, $decode);
			$d--;
		}
		
	}
	
	return $input;

}
}
