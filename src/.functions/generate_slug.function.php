<?php

if (!function_exists('generate_slug')) {
function generate_slug( $title ) {
	$title = strip_tags($title);
	// Preserve escaped octets.
	$title = preg_replace('|%([a-fA-F0-9][a-fA-F0-9])|', '---$1---', $title);
	// Remove percent signs that are not part of an octet.
	$title = str_replace('%', '', $title);
	// Restore octets.
	$title = preg_replace('|---([a-fA-F0-9][a-fA-F0-9])---|', '%$1', $title);
	
	$title = remove_accents($title);

	$title = strtolower($title);

	$title = preg_replace('/&.+?;/', '', $title); // kill entities
	//$title = str_replace('.', '-', $title);

	$title = preg_replace('/[^%a-z0-9 _\.-]/', '-', $title);
	$title = preg_replace('/\s+/', '-', $title);
	$title = preg_replace('|-+|', '-', $title);
	$title = trim($title, '-');

	return $title;
}
}
