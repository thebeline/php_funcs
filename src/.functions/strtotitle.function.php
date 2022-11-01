<?php

if (!function_exists('strtotitle')) {
define('STR_TITLE_MULTYBYTE', 1);
define('STR_TITLE_ROMAN',     2);
function strtotitle($string, $delimiters = NULL, Array $exceptions = NULL, $options = 0) {
	
	if(is_null($delimiters)) {
		$delimiters = array(" ");
	} elseif (is_string($delimiters)) {
		$delimiters = array($delimiters);
	}
	
	/**
	 * Exceptions in lower case are words you do not want converted
	 * Exceptions in upper case are words you want in uppercase
	 */
	
	if(is_null($exceptions)) {
		$exceptions = array(
			'of'   => 1, 'a'    => 1, 'the'  => 1, 'and'  => 1, 'an'   => 1,
			'or'   => 1, 'nor'  => 1, 'but'  => 1, 'is'   => 1, 'if'   => 1,
			'then' => 1, 'else' => 1, 'when' => 1, 'at'   => 1, 'from' => 1,
			'by'   => 1, 'on'   => 1, 'off'  => 1, 'for'  => 1, 'in'   => 1,
			'out'  => 1, 'over' => 1, 'to'   => 1, 'into' => 1, 'with' => 1
		);
	} else {
		$exceptions = array_flip($exceptions);
	}
	
	foreach ($delimiters as $delimiter){
		if($options & STR_TITLE_MULTYBYTE) {
			$words = mb_split(preg_quote($delimiter), $string);
			if(count($words) > 1) {
				foreach ($words as &$word) if (
					($len = mb_strlen($word, "UTF-8")) &&
					!isset($exceptions[$word]) &&
					!isset($exceptions[mb_strtolower($word, "UTF-8")]) &&
					$word != ($upper = mb_strtoupper($word, "UTF-8"))
				) {
					if (isset($exceptions[$upper])) {
						$word = $upper;
					} elseif ($options & STR_TITLE_ROMAN &&
						preg_match("/^M{0,4}(CM|CD|D?C{0,3})(XC|XL|L?X{0,3})(IX|IV|V?I{0,3})$/", $upper)
					) {
						$word = $upper;
					} else {
						$upper_char = mb_substr($upper, 0, 1, "UTF-8");
						if(mb_substr($word, 0, 1, "UTF-8") != $upper_char) {
							$word = $upper_char.mb_substr($word, 1, $len, "UTF-8");
						}
					}
				}
				$string = implode($delimiter, $words);
			}
		} else {
			$words = explode($delimiter, $string);
			if(count($words) > 1) {
				foreach ($words as &$word) if (
					!isset($exceptions[$word]) &&
					!isset($exceptions[strtolower($word)]) &&
					$word != ($upper = strtoupper($word))
				) {
					if (isset($exceptions[$upper])) {
						$word = $upper;
					} elseif ($options & STR_TITLE_ROMAN &&
						preg_match("/^M{0,4}(CM|CD|D?C{0,3})(XC|XL|L?X{0,3})(IX|IV|V?I{0,3})$/", $upper)
					) {
						$word = $upper;
					} else {
						$word = ucfirst($word);
					}
				}
				$string = implode($delimiter, $words);
			}
		}
	}
	
	return $string;
}
}
