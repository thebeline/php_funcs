<?php

define('BASE_EXEC', 'php -r '.escapeshellarg(
    "\$pre = get_defined_functions()['user'];(function(\$s) {eval(\$s);})(\$argv[1]);var_export(array_diff(get_defined_functions()['user'], \$pre));"
).' ');

if (debug_backtrace() !== [])
    die(__FILE__.' must only be called alone, from the command line');

$file = $argv[1];

if (!is_readable($file))
    die("File $file does not exist or is not readable");

if (empty($argv[2]) || !is_dir($argv[2]) || !is_writable($argv[2]))
    die("Output directory does not exist, or is not writable.");

$source  = array_slice(explode("\n", file_get_contents($file)), 13);

$skipped = '';

do {

    $length = NULL;

    foreach($source as $i => $line) {
		if(preg_match('/^}/', $line)) {
			$length = $i+1;
            break;
		}
	}

    $function_source = implode("\n", array_slice($source, 0, $length));
    $source          = array_slice($source, $length+1);
    
    $exec = BASE_EXEC.escapeshellarg($function_source);

    exec($exec, $o, $r);

    if ($r || empty($o)) {
        file_put_contents("php://stderr","$exec\nDid something aweful...\n");
        $skipped .= "$function_source\n";
        //die();
        continue;
    }

    $o = 'return '.implode("\n",$o).';';

    $function = eval($o);

    if (!isset($function[0]) || isset($function[1])) {
        file_put_contents("php://stderr","$function_source\nGenerated ".count($function)." functions, which is weird...\n");
        $skipped .= "$function_source\n";
        continue;
    }

    if (!($bytes = file_put_contents("{$argv[2]}/{$function[0]}.function.php", sprintf("<?php\n\nif (!function_exists('%s')) {\n%s\n}\n", $function[0], $function_source))))
        file_put_contents("php://stderr","Unable to write to {$argv[2]}/{$function[0]}.function.php?\n");

} while (count($source));

echo "<?php\n\n$skipped";