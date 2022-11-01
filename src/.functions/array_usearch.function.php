<?php

if (!function_exists('array_usearch')) {
/**
 * Array Usearch
 *
 * Searches a provided array, using a supplied callback. Returns the key of the
 * element for the first element the callback returns true, otherwise,
 * continues searching.  Returns NULL if the callback never returns true.
 *
 * @param iterable $haystack The Array to search on
 * @param callable $callback The Callback that will be performing the search.
 * @param bool &$did_find A sanity bit to confirm the output "should" be null
 *
 * @return mixed The key of the first found item, or NULL if not found.
 *
 * @throws \Exception Argument 2 of array_usearch must be callable.
 *
 * @author Mike Mulligan <michael@bigroomstudios.com>
 */
function array_usearch(iterable $haystack, $callback, &$did_find = null) {
	
	if(!is_callable($callback)) {
		throw \Exception('Argument 2 of array_usearch must be callable.');
	}

	foreach($haystack as $key => $value) {
		if($did_find = (bool) $callback($value, $key)) {
			return $key;
		}
	}

	return NULL;
}
}
