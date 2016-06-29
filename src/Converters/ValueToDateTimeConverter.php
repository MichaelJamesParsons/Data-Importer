<?php
namespace michaeljamesparsons\DataImporter\Converters;

/**
 * Class ValueToDateTimeConverter
 * @package michaeljamesparsons\DataImporter\Converters
 */
class ValueToDateTimeConverter implements IConverter
{
	/** @var  string */
	protected $index;

	/** @var \DateTimeZone */
	private $timezone;

	/**
	 * ValueToDateTimeConverter constructor.
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