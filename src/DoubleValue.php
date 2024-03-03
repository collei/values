<?php
namespace Collei\Values;

use Collei\Values\Concerns\Numeric;

/**
 * Type abstraction layer for loading from/saving to files
 *
 * @author Alarido Su <alarido.su@gmail.com>
 * @author Collei Inc. <collei@collei.com.br>
 */
class DoubleValue extends IntegerValue implements Numeric
{
	/**
	 * @var string
	 */
	protected $type = 'double';
}
