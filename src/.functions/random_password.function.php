<?php

if (!function_exists('random_password')) {
function random_password($len = 8)
{
   $pass = '';
   $lchar = 0;
   $char = 0;
   for($i = 0; $i < $len; $i++)
   {
	   while($char == $lchar)
	   {
		   $char = rand(48, 109);
		   if($char > 57) $char += 7;
		   if($char > 90) $char += 6;
	   }
	   $pass .= chr($char);
	   $lchar = $char;
   }
   return $pass;
}
}
