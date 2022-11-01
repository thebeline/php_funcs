<?php

if (!function_exists('utfstring_to_ords')) {
/**
 * Given a UTF-8 string, output an array of ordinal values.
 *
 * @param string $input
 *   UTF-8 string.
 * @param string $encoding
 *   Defaults to UTF-8.
 *
 * @return array
 *   Array of ordinal values representing the input string.
 */
function utfstring_to_ords($input, $encoding = 'UTF-8'){
  // Turn a string of unicode characters into UCS-4BE, which is a Unicode
  // encoding that stores each character as a 4 byte integer. This accounts for
  // the "UCS-4"; the "BE" prefix indicates that the integers are stored in
  // big-endian order. The reason for this encoding is that each character is a
  // fixed size, making iterating over the string simpler.
  $input = mb_convert_encoding($input, "UCS-4BE", $encoding);

  // Visit each unicode character.
  $ords = array();
  for ($i = 0; $i < mb_strlen($input, "UCS-4BE"); $i++) {
    // Now we have 4 bytes. Find their total numeric value.
    $s2 = mb_substr($input, $i, 1, "UCS-4BE");
    $val = unpack("N", $s2);
    $ords[] = $val[1];
  }
  return $ords;
}
}
