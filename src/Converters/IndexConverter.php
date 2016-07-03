<?php
namespace michaeljamesparsons\DataImporter\Converters;

/**
 * Class IndexConverterInterface
 * @package michaeljamesparsons\DataImporter\Converters
 */
class IndexConverter implements ConverterInterface
{
	/** @var  string */
	protected $index;

	/** @var  string */
	protected $rename;

	/**
	 * IndexConverterInterface constructor.
	 *
	 * @param $index
	 * @param $rename
	 */
	public function __construct($index, $rename)
	{
		$this->index  = $index;
		$this->rename = $rename;
	}

	/**
	 * @inheritdoc
	 */
	public function convert(array $item)
	{
		if(!empty($item[$this->index])) {
			//Move value from old index to new.
			$item[$this->rename] = $item[$this->index];

			//remove old index.
			unset($item[$this->index]);
		}

		return $item;
	}
}