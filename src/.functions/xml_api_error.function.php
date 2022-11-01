<?php

if (!function_exists('xml_api_error')) {
/*
 * Name: api_error
 * Description: Creates XML output and reports an error if one occurs
 * 
 * @param $error_msg | string
*/
	
function xml_api_error($error_msg) {
	$DOM = new DOMDocument('1.0', 'iso-8859-1');
	$root = $DOM->createElement('error');
	$DOM->appendChild($root);
	$error_node = $DOM->createElement('error_message',$error_msg);
	$root->appendChild($error_node);
	$DOM->formatOutput = true;
	die($DOM->saveXML());
}
}
