<?php

if (!function_exists('http_exit')) {
//http_response_code(200);
//print_pre([apache_response_headers(), sdagf()]);

function http_exit(Int $code) {
	http_response_code($code);
	exit;
}
}
