<?php
namespace Collei\Types;

use Closure;

/**
 * Type abstraction layer for loading from/saving to files
 *
 * @author Alarido Su <alarido.su@gmail.com>
 * @author Collei Inc. <collei@collei.com.br>
 */
class ArrayValue extends Value
{	
	/**
	 * @var string
	 */
	protected $type = 'array';

	/**
	 * Tells if the current is equals to the given one.
	 *
	 * @param self $other
	 * @return bool
	 */
	public function equals($other)
	{
		return (get_class($other) === get_class($this)) && ($other->value == $this->value);
	}

	/**
	 * Iterates the array items by using a callable.
	 *
	 * The callback function ($value, $key) receives the value as the first
	 * argument and the current index as the second. If you want to change the
	 * value in the array, declare it as passing by reference (&$value, $key)
	 *
	 * @param \Closure $callback
	 * @return array
	 */
	public function each(Closure $callback)
	{
		$result = [];

		foreach ($this->value as $key => $val) {
			$res = $callback($val, $key);

			if (false === $res) break;

			if (null === $res) continue;

			$result[$key] = $res;
		}

		return $result;
	}
}
