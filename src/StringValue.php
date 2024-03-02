<?php
namespace Collei\Types;

/**
 * Type abstraction layer for loading from/saving to files
 *
 * @author Alarido Su <alarido.su@gmail.com>
 * @author Collei Inc. <collei@collei.com.br>
 */
class StringValue extends Value
{
	/**
	 * @var string
	 */
	protected $type = 'string';

	/**
	 * Implements __toString() behaviour.
	 *
	 * @return string
	 */
	public function __toString()
	{
		return $value;
	}
}
