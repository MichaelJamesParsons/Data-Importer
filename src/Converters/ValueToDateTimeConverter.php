<?php
namespace michaeljamesparsons\DataImporter\Converters;

/**
 * Class ValueToDateTimeConverterInterface
 * @package michaeljamesparsons\DataImporter\Converters
 */
class ValueToDateTimeConverterInterface implements ConverterInterface
{
	/** @var  string */
	protected $index;

	/** @var \DateTimeZone */
	private $timezone;

	/**
	 * ValueToDateTimeConverterInterface constructor.
	 *
	 * @param               $index
	 * @param \DateTimeZone $timezone
	 */
	public function __construct($index, \DateTimeZone $timezone = null)
	{
		$this->index  = $index;
		$this->timezone = $timezone;
	}

	/**
	 * @inheritdoc
	 */
	public function convert(array $item)
	{
		$value = trim($item[$this->index]);

		if(!empty($value)) {
			$item[$this->index] = new \DateTime($value, $this->timezone);
		}

		return $item;
	}
}