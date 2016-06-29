<?php
namespace michaeljamesparsons\DataImporter\Converters;

/**
 * Interface IConverter
 * @package michaeljamesparsons\DataImporter\Converters
 */
interface IConverter
{
	/**
	 * Converts an item's indexes and values before being imported.
	 *
	 * @param array $item
	 *
	 * @return array
	 */
	public function convert(array $item);
}