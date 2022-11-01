<?php

if (!function_exists('list_dir')) {


//list files in a directory limited to fiels of a certain type
//directory is a complete path fromt the server root
//file types are listed as comma seperated list eg. 'jpg,gif,png'

function list_dir($path, $file_types = ''){

	$files = array();

	$file_type_array = explode(',', $file_types);

	if(is_dir($path)){

		$dh  = opendir($path);

		while ($item = readdir($dh)) {

			if($file_types){

					$ext_array = explode('.', $item);
					$ext = end($ext_array);

					foreach($file_type_array as $file_type){
						if($file_type == $ext){
							$files[] = $item;
							break;
						}
					}

			}else{
		   		$files[] = $item;
			}
		}
	}
	asort($files);
	return $files;
}
}
