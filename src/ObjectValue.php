<?php
namespace Collei\Types;

/**
 * Type abstraction layer for loading from/saving to files
 *
 * @author Alarido Su <alarido.su@gmail.com>
 * @author Collei Inc. <collei@collei.com.br>
 */
class ObjectValue extends Value
{
	/**
	 * @var string
	 */
	protected $type = 'object';

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
}
