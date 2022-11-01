<?php

if (!function_exists('ords_to_utfstring')) {
/**
 * Given an array of ints representing Unicode chars, outputs a UTF-8 string.
 *
 * @param array $ords
 *   Array of integers representing Unicode characters.
 * @param bool $scrub_XML
 *   Set to TRUE to remove non valid XML characters.
 *
 * @return string
 *   UTF-8 String.
 */
function ords_to_utfstring($ords, $scrub_XML = FALSE) {
  $output = '';
  foreach ($ords as $ord) {
    // 0: Negative numbers.
    // 55296 - 57343: Surrogate Range.
    // 65279: BOM (byte order mark).
    // 1114111: Out of range.
    if (   $ord < 0
        || ($ord >= 0xD800 && $ord <= 0xDFFF)
        || $ord == 0xFEFF
        || $ord > 0x10ffff) {
      // Skip non valid UTF-8 values.
      continue;
    }
    // 9: Anything Below 9.
    // 11: Vertical Tab.
    // 12: Form Feed.
    // 14-31: Unprintable control codes.
    // 65534, 65535: Unicode noncharacters.
    elseif ($scrub_XML && (
               $ord < 0x9
            || $ord == 0xB
            || $ord == 0xC
            || ($ord > 0xD && $ord < 0x20)
            || $ord == 0xFFFE
            || $ord == 0xFFFF
            )) {
      // Skip non valid XML values.
      continue;
    }
    // 127: 1 Byte char.
    elseif ( $ord <= 0x007f) {
      $output .= chr($ord);
      continue;
    }
    // 2047: 2 Byte char.
    elseif ($ord <= 0x07ff) {
      $output .= chr(0xc0 | ($ord >> 6));
      $output .= chr(0x80 | ($ord & 0x003f));
      continue;
    }
    // 65535: 3 Byte char.
    elseif ($ord <= 0xffff) {
      $output .= chr(0xe0 | ($ord >> 12));
      $output .= chr(0x80 | (($ord >> 6) & 0x003f));
      $output .= chr(0x80 | ($ord & 0x003f));
      continue;
    }
    // 1114111: 4 Byte char.
    elseif ($ord <= 0x10ffff) {
      $output .= chr(0xf0 | ($ord >> 18));
      $output .= chr(0x80 | (($ord >> 12) & 0x3f));
      $output .= chr(0x80 | (($ord >> 6) & 0x3f));
      $output .= chr(0x80 | ($ord & 0x3f));
      continue;
    }
  }
  return $output;
}
}
