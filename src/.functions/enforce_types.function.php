<?php

if (!function_exists('enforce_types')) {
/**
 * Enforce Scalar Datatypes
 *
 * This function allows enforceing Scalar datatypes. When called at the head of
 * a function or method and provided with 'func_get_args' will ensure that the
 * parameters passed are of the correct scalar type. Setting an index to NULL
 * allows not validating that index. Setting $allow_null to FALSE forces the
 * $values to be set if a scalar definition is set. Causes a Fatal Error by
 * default. Set $return to TRUE to simply validate the variables.
 *
 * @param mixed[] $values The values to validate.
 * @param mixed[] $scalars An associative array of Scalar types to validate in $values.
 * @param bool $allow_null (optional) Wetther or not to allow NULL values to pass through as valid (if scalar definition is set).
 * @param bool $return (optional) Wether to return (validate). Defaults to FALSE, or Fatal Error (same as Type Hinting).
 *
 * @return bool Wether all Scalar tests passed or not.
 *
 * @author Michael Mullligan <michael@bigroomstudios.com>
 */
function enforce_types(Array $values, Array $value_types, Array $options = NULL) {
	static $_array_alike = [\ArrayAccess::class, \Traversable::class, \Serializable::class, \Countable::class];
	$options = fill_defaults((array) $options, array(
			'allow_null'   => TRUE,
			'exception'    => TRUE,
			'soft_numeric' => FALSE
	));
	$error = FALSE;
	foreach($value_types as $key => $type_def) {
		$_type_def = $type_def;
		if(is_null($_type_def))
			continue;
		if((!array_key_exists($key, $values) || is_null($values[$key])) && (bool) $options['allow_null'])
			continue;
		if (is_string($_type_def))
			$_type_def = explode('|', $_type_def);
		if (!is_array($_type_def))
			throw new \Exception("Type Enforce Call-Error: Unexpected Type declaration type'".get_type($_type_def)."', expected String or Array.");
		$value = array_key_exists($key, $values) ? $values[$key] : NULL;
		foreach($_type_def as $type) {
			if(!is_string($type))
				throw new \Exception("Type Enforce Call-Error: Unexpected Type declaration type'".get_type($type)."', expected String or NULL.");
			$valid = FALSE;
			$soft = $options['soft_numeric'];
			switch(strtolower($type)) {
				case 'mixed':
					$valid = true;
					break;
				case 'array':
					$valid = is_array($value);
					break;
				case 'bool':
				case 'boolean':
					$valid = is_bool($value);
					break;
				case 'soft_float':
					$soft = TRUE;
				case 'float':
				case 'double':
				case 'real':
					if($soft && $value != (float) $value) {
						break;
					}
					$valid = is_float($value);
					break;
				case 'soft_int':
					$soft = TRUE;
				case 'int':
				case 'integer':
					if($soft && $value != (int) $value) {
						break;
					}
					$valid = is_int($value);
					break;
				case 'void':
				case 'unset':
				case 'null' :
					$valid = is_null($value);
					break;
				case 'object':
					$valid = is_object($value);
					break;
				case 'string':
					$valid = is_string($value);
					break;
				case 'scalar':
					$valid = is_scalar($value);
					break;
				case 'numeric':
					$valid = is_numeric($value);
					break;
				case 'callable':
					$valid = is_callable($value);
					break;
				case 'resource':
					$valid = is_resource($value);
					break;
				default:
					if (class_exists($type) || interface_exists($type) || trait_exists($type)) {
						$valid = is_a($value, $type);
						if (!$valid && is_array($value))
							$valid = in_array(ltrim($type, '\\'), $_array_alike);
					} else
						throw new \Exception("Enforce Type Call-Error: Unrecognized Type '$type'.");
			}
			
			if($valid) break;
		}
		
		if(!$valid) {
			$error_message = "Type Enforcement Error: Expected type '$type_def' for index $key, '".(is_object($value) ? '\\'.get_class($value) : gettype($value))."' given.";
			if(!empty($options['exception'])) {
				throw new \Exception($error_message);
			} else {
				trigger_error($error_message, E_USER_WARNING);
			}
		}
		
		$error = $error || !$valid;
	}
	return (bool) !$error;
}
}
