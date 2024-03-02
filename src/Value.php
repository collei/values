<?php
namespace Collei\Types;

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
abstract class Value
{
	/**
	 * @var string
	 */
	protected $name;

	/**
	 * @var mixed
	 */
	protected $value;

	/**
	 * @var string
	 */
	protected $type;

	/**
	 * @var \DateTimeInterface
	 */
	protected $time;

	/**
	 * @var array
	 */
	protected $tags = [];

	/**
	 * Generates a name from the given $type and $time.
	 *
	 * @static
	 * @param string $type
	 * @param \DateTimeInterface $time
	 * @return string
	 */
	protected static function generateUniqueName(string $type, DateTimeInterface $time)
	{
		return str_replace('\\', '.', $type) . '_' . $time->format('YmdHisu');
	} 

	/**
	 * Loads the object from the given $filename.
	 *
	 * @static
	 * @param string $filename
	 * @return instanceof static|null
	 */
	public static function loadFromFile(string $filename)
	{
		if (file_exists($filename) && ($data = file_get_contents($filename))) {
			try {
				$object = unserialize($data);

				if ($object instanceof static) {
					return $object;
				}
			} catch (Throwable $t) {
				return null;
			}
		}

		return null;
	}

	/**
	 * Saves the object to the given $filename.
	 *
	 * @static
	 * @param self $data
	 * @param string $filename
	 * @return void
	 */
	public static function saveToFile(self $data, string $filename)
	{
		file_put_contents($filename, serialize($data));
	}

	/**
	 * Create a new object handler for the given value.
	 *
	 * @static
	 * @param mixed $value
	 * @param string $name = null
	 * @return static
	 */
	public static function make($value, string $name = null)
	{
		return new static($value, $name);
	}

	/**
	 * Create a new object handler for the given value.
	 *
	 * @static
	 * @param mixed $value
	 * @param string $name = null
	 * @param \DateTimeInterface $time = null
	 * @return void
	 * @throws \
	 */
	public function __construct(
		$value,
		string $name = null,
		DateTimeInterface $time = null,
		string ...$tags
	) {
		if (! is_object($value) && (gettype($value) !== $this->type)) {
			throw new InvalidArgumentException('Value must be of type ' . $this->type);
		}

		if (is_object($value) && ('object' !== $this->type)) {
			throw new InvalidArgumentException('Value must be of type ' . $this->type);
		}

		if (is_object($value)) {
			$this->type = get_class($value);
		}

		$this->value = $value;
		$this->time = $time ?? new DateTime();
		$this->name = $name ?? self::generateUniqueName($this->type, $this->time);

		if (! empty($tags)) {
			$this->addTags(...$tags);
		}
	}

	/**
	 * Returns the subjacent value.
	 *
	 * @return mixed
	 */
	public function get()
	{
		return $this->value;
	}

	/**
	 * Returns the subjacent value type.
	 *
	 * @return string
	 */
	public function getType()
	{
		return $this->type;
	}

	/**
	 * Returns the subjacent value name.
	 *
	 * @return string
	 */
	public function getName()
	{
		return $this->name;
	}

	/**
	 * Returns the subjacent value time.
	 *
	 * @return \DateTimeInterface
	 */
	public function getTime()
	{
		return $this->time;
	}

	/**
	 * Returns the subjacent value tags.
	 *
	 * @return array
	 */
	public function getTags()
	{
		return $this->tags;
	}

	/**
	 * Returns the subjacent value time.
	 *
	 * @return \DateTimeInterface
	 */
	public function hasTag(string $tag)
	{
		return array_key_exists($tag, $this->tags);
	}

	/**
	 * Adds the given tag to the value.
	 *
	 * @return $this
	 */
	public function addTag(string $tag)
	{
		$this->tags[$tag] = true;

		return $this;
	}

	/**
	 * Adds the given tags to the value.
	 *
	 * @return array
	 */
	public function addTags(string ...$tags)
	{
		foreach ($tags as $tag) {
			$this->addTag($tag);
		}

		return $this;
	}

	/**
	 * Set the subjacent value.
	 *
	 * @return $this
	 * @throws \InvalidArgumentException when value type does not match the previous one's
	 */
	public function set($value)
	{
		if (is_object($value) && get_class($value) !== $this->type) {
			throw new InvalidArgumentException('Value is not the same type of previous value!');
		}

		if (gettype($value) !== $this->type) {
			throw new InvalidArgumentException('Value is not the same type of previous value!');
		}

		$this->value = $value;

		return $this;
	}

	/**
	 * Save to the file.
	 *
	 * @param string $filename
	 * @return void
	 */
	public function saveTo(string $filename)
	{
		static::saveToFile($this, $filename);
	}

	/**
	 * Tells if the current is equals to the given one.
	 *
	 * @param self $other
	 * @return bool
	 */
	public function equals($other)
	{
		return (get_class($other) === get_class($this)) && ($other->value === $this->value);
	}
}
