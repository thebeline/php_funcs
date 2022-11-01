<?php

if (!function_exists('array2xml')) {
function array2xml(Array $data, \DOMNode $parent = null) {
	if (!isset($parent))
		$parent = $document = new DOMDocument('1.0', 'iso-8859-1');
	else
		$document = $parent->ownerDocument;
	foreach ($data as $key => $data) {
		if (is_array($data))
			$node = array2xml($data, $document->createElement($key));
		else
			$node = $document->createElement($key, (string) $data);
		$parent->appendChild($node);
	}
	return $parent;
}
}
