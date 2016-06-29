<?php
namespace michaeljamesparsons\DataImporter\Readers;

use michaeljamesparsons\DataImporter\Converters\IConverter;
use michaeljamesparsons\DataImporter\Filters\IFilterable;

/**
 * Class AbstractReader
 * @package michaeljamesparsons\DataImporter\Readers
 */
abstract class AbstractReader implements \Iterator
{
	/** @var  array */
	protected $filters;

	/** @var  array */
	protected $converters;

	public function __construct()
	{
		$this->filters    = [];
		$this->converters = [];
	}

	/**
	 * Adds a filter to the reader's filter queue.
	 *
	 * @param IFilterable $filter
	 *
	 * @return $this
	 */
	public function addFilter(IFilterable $filter) {
		$this->filters[] = $filter;
		return $this;
	}

	/**
	 * Determines if an item meets the requirements to be filtered.
	 *
	 * @param array $item
	 *
	 * @return bool
	 */
	public function filter(array $item) {
		/** @var IFilterable $filter */
		foreach($this->filters as $filter) {
			if(!$filter->filter($item)) {
				return false;
			}
		}

		return true;
	}

	/**
	 * @param IConverter $converter
	 *
	 * @return $this
	 */
	public function addConverter(IConverter $converter)
	{
		$this->converters[] = $converter;
		return $this;
	}

	/**
	 * @param $item
	 *
	 * @return array
	 */
	public function convert($item) {
		/** @var IConverter $converter */
		foreach($this->converters as $converter) {
			$item = $converter->convert($item);
		}

		return $item;
	}
}