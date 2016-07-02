<?php
namespace michaeljamesparsons\DataImporter\Writers;

use michaeljamesparsons\DataImporter\Cache\AbstractCacheDriver;
use michaeljamesparsons\DataImporter\Cache\Drivers\DictionaryCacheDriver;

/**
 * Class AbstractWriter
 * @package michaeljamesparsons\DataImporter\Writers
 */
abstract class AbstractWriter
{
	/** @var  AbstractCacheDriver */
	protected $cache;

	/** @var  bool */
	protected $cacheEnabled;

	/**
	 * AbstractWriter constructor.
	 *
	 * @param AbstractCacheDriver $cache
	 */
	public function __construct(AbstractCacheDriver $cache = null)
	{
		$this->cache = (!empty($cache)) ? $cache : new DictionaryCacheDriver();

		/**
		 * Caching is disabled by default to optimize the speed and memory usage of this writer. It should
		 * be enabled when a writer requires the storage of key mappings of objection relationships, or information
		 * that must persist across multiple readers.
		 */
		$this->cacheEnabled = false;
	}

	/**
	 * Checks if caching is enabled for this writer.
	 *
	 * @return bool
	 */
	public function isCacheEnabled() {
		return $this->cacheEnabled;
	}

	/**
	 * Import a single item.
	 *
	 * @param array $item   - The item to import.
	 */
	public abstract function write(array $item);

	/**
	 * Prepare writer before the import begins.
	 *
	 * Used to perform tasks and set conditions that must be completed in order for
	 * the writer to properly write each item.
	 */
	public function before() {}

	/**
	 * Shut down writer after import.
	 *
	 * Used to unset the conditions that required for the writer to function.
	 */
	public function after() {}
}