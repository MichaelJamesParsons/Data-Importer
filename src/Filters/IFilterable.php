<?php
namespace michaeljamesparsons\DataImporter\Filters;

/**
 * Interface IFilterable
 * @package michaeljamesparsons\DataImporter\Filters
 */
interface IFilterable
{
	/**
	 * @param array $item
	 *
	 * @return bool
	 */
	public function filter(array $item);
}