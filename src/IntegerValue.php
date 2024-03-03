<?php
namespace Collei\Values;

use Collei\Values\Concerns\Numeric;

/**
 * Type abstraction layer for loading from/saving to files
 *
 * @author Alarido Su <alarido.su@gmail.com>
 * @author Collei Inc. <collei@collei.com.br>
 */
class IntegerValue extends Value implements Numeric
{
	/**
	 * @var string
	 */
	protected $type = 'integer';
}
