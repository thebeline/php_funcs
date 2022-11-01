<?php

if (!function_exists('mime_content_type')) {
	function mime_content_type($f) {
		return (string) trim((string) shell_exec('file -bi '.escapeshellarg($f)));
	}
}