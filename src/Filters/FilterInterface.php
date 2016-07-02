<?php
namespace michaeljamesparsons\DataImporter\Filters;

/**
 * Interface FilterInterface
 * @package michaeljamesparsons\DataImporter\Filters
 */
interface FilterInterface
{
	/**
	 * @param array $item
	 *
	 * @return bool
	 */
	public function filter(array $item);
}