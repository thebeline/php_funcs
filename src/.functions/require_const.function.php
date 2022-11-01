<?php

if (!function_exists('require_const')) {
function require_const($constant) {
	if(!is_defined($constant)) trigger_error("Required Constant '$constant' is not defined.", E_USER_ERROR);
}
}
