<?php
namespace michaeljamesparsons\DataImporter\Writers;

use michaeljamesparsons\DataImporter\Cache\AbstractCacheDriver;

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
     *
     * @param AbstractCacheDriver $driver
     */
	public function __construct(AbstractCacheDriver $driver = null)
	{
        parent::__construct($driver);
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