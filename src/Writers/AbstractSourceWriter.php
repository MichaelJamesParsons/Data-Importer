<?php
namespace michaeljamesparsons\DataImporter\Writers;

use michaeljamesparsons\DataImporter\Cache\AbstractCacheDriver;
use michaeljamesparsons\DataImporter\Cache\Drivers\DictionaryCacheDriver;
use michaeljamesparsons\DataImporter\Context\AbstractSourceWriterContext;
use michaeljamesparsons\DataImporter\Context\EntityContext;

/**
 * Class AbstractSourceWriter
 * @package michaeljamesparsons\DataImporter\Writers
 */
abstract class AbstractSourceWriter extends AbstractWriter implements SourceWriterInterface
{
    /** @var  AbstractCacheDriver */
    protected $cache;

    /** @var  bool */
    protected $cacheEnabled;

    /** @var  AbstractSourceWriterContext */
    protected $context;

    /**
     * AbstractWriter constructor.
     *
     * @param AbstractSourceWriterContext $context
     * @param AbstractCacheDriver         $cache
     */
    public function __construct(AbstractSourceWriterContext $context ,AbstractCacheDriver $cache = null)
    {
        $this->context = $context;
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

    public function write(array $item, $entity) {}
}