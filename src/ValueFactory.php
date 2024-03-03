<?php
namespace Collei\Values;

use DateTime;
use DateTimeInterface;
use Throwable;
use InvalidArgumentException;

/**
 * Type abstraction layer for loading from/saving to files
 *
 * @author Alarido Su <alarido.su@gmail.com>
 * @author Collei Inc. <collei@collei.com.br>
 */
abstract class ValueFactory
{
	/**
	 * Create a new object handler for the given value according its type.
	 *
	 * @static
	 * @param mixed $value
	 * @param string $name = null
	 * @return instanceof Value
	 */
	public static function make($value, string $name = null)
	{
		if (is_object($value)) {
			return ObjectValue::make($value, $name); 
		}

		$typeof = gettype($value);

		switch ($typeof) {
			case 'boolean':
				return BooleanValue::make($value, $name);
			case 'integer':
				return IntegerValue::make($value, $name);
			case 'double':
				return DoubleValue::make($value, $name);
			case 'string':
				return StringValue::make($value, $name);
			case 'array':
				return ArrayValue::make($value, $name);
		}

		throw new InvalidArgumentException('Unsupported value type: ' . $typeof);
	}
}
