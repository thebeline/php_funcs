<?php

if (!function_exists('xmlsafenode')) {
/*
 * Name: SafeNode()
 * Description: Create CDATA node with invalid-char safe output and appends it to an existing node
 * 
 * @param $DOM | reference to existing DOMDocument object
 * @param $parent_node | reference to existing DOM object node which will parent the newly created safe node
 * @param $node_name | The safe node's name
 * @param $node_value | The safe node's value
*/

function XMLSafeNode($DOM,$parent_node,$node_name,$node_value) {

	// Remove MS non-ASCII chars
	// Define $safe_node_value
	
	//$safe_node_value = preg_replace("/[^\x9\xA\xD\x20-\x7F]/", "", $node_value);
	
	$safe_node_value = preg_replace('/[^(\x20-\x7F)]*/','',$node_value);
	
	// Remove ??? from $safe_node_value
	// Redefine $safe_node_value

	$safe_node_value = str_replace("???", "", $safe_node_value);

	$element_node = $DOM->createElement($node_name);
	$cdata_node = $DOM->createCDATASection($safe_node_value);

	$element_node->appendChild($cdata_node);
	$parent_node->appendChild($element_node);

}
}
