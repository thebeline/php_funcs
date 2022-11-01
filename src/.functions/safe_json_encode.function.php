<?php

if (!function_exists('safe_json_encode')) {
function safe_json_encode($value, $options = 0, $depth = 512, $utfErrorFlag = false) {
    if (FALSE === ($encoded = json_encode($value, $options, $depth))) {
		switch (json_last_error()) {
			case JSON_ERROR_UTF8:
				if ($utfErrorFlag)
					break;
				$encoded = safe_json_encode(utf8ize($value), $options, $depth, true);
			case JSON_ERROR_NONE:
				break;
		}
		_trigger_error( json_last_error_msg(), E_USER_WARNING, $utfErrorFlag ? 2 : 1);
	}
	return $encoded;
}
}
