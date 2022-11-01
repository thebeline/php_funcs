<?php

if (!function_exists('generate_username')) {
function generate_username($first_name, $last_name, $mi = '') {
	return strtolower("{$first_name[0]}{$mi[0]}".substr("$last_name", 0, 8));;
}
}
