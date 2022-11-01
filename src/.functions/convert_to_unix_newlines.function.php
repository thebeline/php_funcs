<?php

if (!function_exists('convert_to_unix_newlines')) {
/**
 * convert_to_unix_newlines TEXT
 * Return a copy of TEXT in which all DOS/RFC822-style line-endings (CRLF,
 * "\r\n") have been converted to UNIX-style line-endings (LF, "\n").
 */
function convert_to_unix_newlines($text) {
	$text = preg_replace("/(\r\n|\n|\r)/s", "\n", $text);
	return $text;
}
}
