<?php
namespace michaeljamesparsons\DataImporter\Writers;

/**
 * Class ArrayWriter
 * @package michaeljamesparsons\DataImporter\Writers
 *
 * Writes data to an array. This is generally used for testing import filters and converters
 * before writing the data to a file or database.
 */
class ArrayWriter extends AbstractWriter
{
	/**
	 * The data collected from the reader.
	 *
	 * @var array
	 */
	protected $data;

	/**
	 * ArrayWriter constructor.
	 */
	public function __construct()
	{
		$this->data = [];
	}

	/**
	 * Import a single item.
	 *
	 * @param array $item - The item to import.
	 */
	public function write(array $item)
	{
		$this->data[] = $item;
	}
}