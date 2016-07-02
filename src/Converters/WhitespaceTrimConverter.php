<?php
namespace michaeljamesparsons\DataImporter\Converters;

/**
 * Class WhitespaceTrimConverterInterface
 * @package michaeljamesparsons\DataImporter\Converters
 */
class WhitespaceTrimConverterInterface implements ConverterInterface
{
	/** @var  array */
	protected $indexes;

	public function __construct(array $indexes)
	{
		$this->indexes = $indexes;
	}

	/**
	 * @inheritdoc
	 */
	public function convert(array $item)
	{
		foreach($this->indexes as $index) {
			if(!empty($item[$index])) {
				$item[$index] = preg_replace('/n/', '', trim($item[$index]));
			}
		}

		return $item;
	}
}