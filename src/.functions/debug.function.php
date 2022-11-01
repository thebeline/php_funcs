<?php

if (!function_exists('debug')) {
define('DEBUG_NONE',  0);  // LOOSER
define('DEBUG_TRACE', 1);  // Bactrace, huge deal
define('DEBUG_ERROR', 2);  // Error, pretty big deal
define('DEBUG_WARN',  4);  // Warning, hey, you really should know...
define('DEBUG_LOG',   8);  // Log, you may want to know
define('DEBUG_TABLE', 16); // Table, if you are fairly interested
define('DEBUG_INFO',  32); // Info, god, you want to know everything, eh?
define('DEBUG_ALL', DEBUG_TRACE | DEBUG_ERROR | DEBUG_WARN | DEBUG_LOG | DEBUG_TABLE | DEBUG_INFO);



/**
 * In-Place Debugger
 *
 * Submits data for debugging purposes either to the Client via FirePHP,
 * or, failing that, to the PHP log.
 *
 * Conditionality based on current Debug Level.
 *
 * @warning	This can fill Headers to the point where Chrome will not display
 * 			the page.  Use with care.  Setting $config['debug'] to 0 will allow
 * 			selective debugging only direct to the error log, setting it to -1
 * 			will allow selective logging to the Browser.  Any positive int will
 * 			that level to the browser globaly.  VBI.
 *
 * @param	$type	STRING	The Type of debug Payload this is.
 * @param	$name	STRING	The Name to give this Payload.
 * @param	$var	MIXED	Optional data for this Payload
 *
 * @todo This may be even better suited if it weren't even using FirePHP, or if
 * we could bypass FirePHP entirely, maybe log to individual log files, or the
 * database (so cross-server).  I haven't decided.  I am sure this can be made
 * more useful.  It is already more usefu than it WAS, but it could still be
 * better, I feel...  An actual class maybe??
 */
function debug($class, $name, $var = NULL, $filter_source = NULL){
	
	// If we are not skipping (-1), let's dance.
	static $lets_do_this = TRUE;
	if(empty($lets_do_this))
		return FALSE;
	
	// $reporting_base should be set to 0 if there are filters, once implemented.
	static $reporting_base = NULL;
	if($reporting_base === NULL)
		$reporting_base = (int) (defined('DEBUG_REPORTING') ? DEBUG_REPORTING : DEBUG_NONE);
	
	
	// Supposed to get the filters, editable via Admin.  Soon
	static $debug_filters = FALSE;
	/*if($debug_filters === FALSE) {
		$cacher = new \Cache();
		$debug_filters = (array) $cacher->get('debug', NULL, TRUE, FALSE);
	}*/
	
	if (empty($reporting_base) && empty($debug_filters))
		return $lets_do_this = FALSE;
	
	static $types = array(
		DEBUG_TRACE => 'trace',
		DEBUG_ERROR => 'error',
		DEBUG_WARN  => 'warn',
		DEBUG_LOG   => 'log',
		DEBUG_TABLE => 'table',
		DEBUG_INFO  => 'info',
	);
	// Resolve Type
	foreach($types as $bit => $type)
		if($found = ($class & $bit)) break;
	
	if (empty($found))
		return FALSE;
	
	$trace_offset = 1;
	
	if (!empty($filter_source)) {
		if (is_array($filter_source))
			$trace = $filter_source;
		elseif (is_object($filter_source) && $filter_source instanceof \Exception)
			$trace = $filter_source->getTrace()[0];
		elseif (is_int($filter_source) && $filter_source > 0)
			$trace_offset += $filter_source;
		
		if (!is_string($filter_source))
			$filter_source = NULL;
	}
	
	// Set the current Reporting Level
	$reporting = (bool) ($reporting_base & $class);
	
	// If Debug Filters are set, AND the Filter String is Present.
	if(!$reporting && !empty($debug_filters)) {
		
		// If no Filter String Provided, build one.
		if(empty($filter_source)) {
			if (empty($trace)) {
				if (is_object($var) && $var instanceof \Exception)
					$trace = $var->getTrace()[0];
				else
					$trace = debug_backtrace_offset($trace_offset);
			}
			$filter_source = $trace_string = debug_get_trace_string($trace);
		}
		
		// If the Filter String matches ANY on the avaliable filters, let's find out which one...
		if(@preg_match('/('.implode('|',array_keys($debug_filters)).')$/i', $filter_source)) {
			// Check each debug_filter
			foreach((array) $debug_filters as $match => $match_reporting) {
				// If this match would raise an acceptable flag, and the match is present in the filter string.
				if(!($match_reporting & $class) && @preg_match('/^'.$match.'$/i', $filter_source)) {
					// Raise to the match level.
					$reporting = TRUE;
					break;
				}
			}
		}
	}
	
	// Do not Debug if we are not displaying messages at this level.
	if(!$reporting)
		return FALSE;
	
	if (is_object($var) && get_class($var) === 'Closure')
		$var = $var();
	
	/**
	 * If the DEBUG_REPORTING is set and non-zero, and headers not sent, send
	 * to browser.  FALSE for now, because no FirePHP
	 */
	if(FALSE && !headers_sent()) {
		
		// Attempt to load FirePHP if we haven't already.
		static $firephp = NULL;
		if(is_null($firephp)) {
			
			include_once('FirePHPCore/FirePHP.class.php');
			
			// If we got it, load it.
			if($firephp = class_exists('FirePHP', TRUE)) {
				$firephp = FirePHP::getInstance(true);
				$options = array(
					'maxObjectDepth' => 5,
					'maxArrayDepth' => 5,
					'maxDepth' => 10,
					'useNativeJsonEncode' => true,
					'includeLineNumbers' => true
				);
				
				$firephp->setOptions($options);
			}
		}
		
		if($firephp != FALSE) {
			
			// Going to have to reverse-resolve the types
			if($type == 'error')
				$firephp->group($name);
			
			$reporting = $firephp->$type($var, $name);
			
			if($type == 'error')
				//$return = ($return && $firephp->trace($name));
				$firephp->groupEnd();
			
		}
		
	}
	
	if (empty($trace))
		$trace = debug_backtrace_offset($trace_offset, 1, 0);
	
	if (empty($trace_string))
		$trace_string = debug_get_trace_string($trace[0] ?: $trace );
	
	$logged = error_logr(
		sprintfn(
			"DEBUG (%1\$s): %2\$s in %3\$s ---\n%4\$s",
			[
				strtoupper($type),
				$name,
				$trace_string,
				print_r(is_scalar($var) ? $var : niceArray($var, 1), true)
			]
		),
		3,
		"logs/debug.log"
	);
	
	return $logged && $reporting;
		
}
}
