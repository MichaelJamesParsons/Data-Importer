<?php
namespace michaeljamesparsons\DataImporter\Converters;

/**
 * Class NestedArrayIndexConverterInterface
 * @package michaeljamesparsons\DataImporter\Converters
 */
class NestedArrayIndexConverter implements ConverterInterface
{
	/** @var  string */
	protected $mapping;

	/**
	 * NestedArrayIndexConverterInterface constructor.
	 *
	 * @param array $mapping
	 */
	public function __construct(array $mapping)
	{
		$this->mapping = $mapping;
	}

	/**
	 * @inheritdoc
	 */
	public function convert(array $item)
	{
		return $this->traverse($item, $this->mapping);
	}

	/**
	 * @param array $item
	 * @param array $mapping
	 *
	 * @return array
	 */
	protected function traverse(array $item, array $mapping) {
		foreach($item as $k => $v) {
			if(array_key_exists($k, $mapping)) {

				if(is_array($v) && is_array($mapping[$k])) {
					$keys = array_keys($mapping[$k]);
					$item[$keys[0]] = $this->traverse($v, $mapping[$k][$keys[0]]);
					unset($item[$k]);

				} elseif(!is_array($v) && !is_array($mapping[$k])) {
					$item[$mapping[$k]] = $v;
					unset($item[$k]);
				}
			}
		}

		return $item;
	}
}