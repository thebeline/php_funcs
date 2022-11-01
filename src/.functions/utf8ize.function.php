<?php

if (!function_exists('utf8ize')) {
function utf8ize( $mixed /*, $recursive = false*/) {
    if (is_array($mixed) /*&& $recursive*/) {
		$mixed = array_map('utf8ize', $mixed);
		/*foreach ($mixed as $key => $value) {
            $mixed[$key] = utf8ize($value, true);
        }*/
    } elseif (is_string($mixed) && !seems_utf8($mixed)) {
		if ($enc = mb_detect_encoding($mixed, "UTF-8, Windows-1252, ISO-8859-1", true))
			$mixed = iconv($enc, "UTF-8//TRANSLIT", $mixed);
		else // The above will nearly always work (because of the ISO), this is really here to show what it once was...
			$mixed = mb_convert_encoding($mixed, "UTF-8", 'Windows-1252');
    }
    return $mixed;
}
}
