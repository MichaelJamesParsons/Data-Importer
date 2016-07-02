<?php
namespace michaeljamesparsons\DataImporter\Writers;

use michaeljamesparsons\DataImporter\Helpers\RecordIndexCache;
use michaeljamesparsons\DataImporter\Helpers\RecordWrapper;

/**
 * Class AbstractDatabaseWriter
 * @package michaeljamesparsons\DataImporter\Writers
 */
abstract class AbstractDatabaseWriter extends AbstractWriter
{
	/**
	 * The number of items imported.
	 * @var int
	 */
	protected $count;

	/**
	 * The number of records to save at one time.
	 * @var int
	 */
	protected $bundleSize;

	/** @var  bool */
	protected $truncate;

	/**
	 * AbstractDatabaseWriter constructor.
	 *
	 * @param int $bundleSize
	 */
	public function __construct($bundleSize = 300)
	{
		parent::__construct();
		$this->bundleSize = $bundleSize;
		$this->count = 0;
		$this->cache  = new RecordIndexCache();
		$this->enableCache = false;
	}

	/**
	 * @return boolean
	 */
	public function truncate()
	{
		return $this->truncate;
	}

	/**
	 * @param boolean $truncate
	 */
	public function setTruncate($truncate)
	{
		$this->truncate = $truncate;
	}

	/**
	 * @inheritdoc
	 */
	public function before()
	{
		if($this->truncate) {
			$this->truncateTable();
		}
	}

	/**
	 * @inheritdoc
	 */
	public function after() {
		$this->flush();
	}

	/**
	 * Fetch an existing record or create a new one if it does not already exist.
	 *
	 * @param RecordWrapper $item
	 * @return object - The record or entity.
	 */
	protected abstract function findOrCreateIfNotExists(RecordWrapper $item);

	/**
	 * Turn on database query logging.
	 */
	protected abstract function enableDatabaseLogging();

	/**
	 * Turn off database query logging.
	 */
	protected abstract function disableDatabaseLogging();

	/**
	 * Truncate the table associated with the records being imported.
	 */
	protected abstract function truncateTable();

	/**
	 * Add parsed item to the bundle to be saved.
	 *
	 * @param $item - The record or entity to be persisted.
	 */
	protected abstract function persist($item);

	/**
	 * Save a bundle of records.
	 */
	protected abstract function flush();
}