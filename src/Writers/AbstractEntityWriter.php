<?php
namespace michaeljamesparsons\DataImporter\Writers;

use Exception;
use michaeljamesparsons\DataImporter\Cache\AbstractCacheDriver;
use michaeljamesparsons\DataImporter\Cache\Drivers\DictionaryCacheDriver;
use michaeljamesparsons\DataImporter\Context\EntityContext;

/**
 * Class AbstractEntityWriter
 * @package michaeljamesparsons\DataImporter\Writers
 */
abstract class AbstractEntityWriter extends AbstractWriter implements RelationalWriterInterface
{
    /**
     * A list of EntityContext objects.
     *
     * @var array
     */
    protected $entities;

    /** @var  AbstractCacheDriver */
    protected $cache;

    /** @var  bool */
    protected $cacheEnabled;

    /**
     * AbstractWriter constructor.
     *
     * @param AbstractCacheDriver         $cache
     */
    public function __construct(AbstractCacheDriver $cache = null)
    {
        $this->cache    = (!empty($cache)) ? $cache : new DictionaryCacheDriver();
        $this->entities = [];

        /**
         * Caching is disabled by default to optimize the speed and memory usage of this writer. It should
         * be enabled when a writer requires the storage of key mappings of objection relationships, or information
         * that must persist across multiple readers.
         */
        $this->cacheEnabled = false;
    }

    /**
     * @param EntityContext $context
     *
     * @return $this
     * @throws \Exception
     */
    public function addEntity(EntityContext $context)
    {
        try {
            $this->getEntityContext($context->getName());
        } catch (Exception $e) {
            $this->entities[] = $context;
            return $this;
        }

        throw new Exception('Entity context "' . $context->getName() . '" has already been defined in this context.');
    }

    /**
     * Finds an entity context with the given name.
     *
     * @param $name
     *
     * @return EntityContext
     * @throws Exception
     */
    public function getEntityContext($name)
    {
        foreach ($this->entities as $context) {
            if ($context->getName() == $name) {
                return $context;
            }
        }

        throw new Exception('Entity context for "' . $name . '" not defined in database context.');
    }

    /**
     * @param array $entities
     */
    public function setEntities($entities)
    {
        $this->entities = $entities;
    }

    /**
     * Checks if caching is enabled for this writer.
     *
     * @return bool
     */
    public function isCacheEnabled()
    {
        return $this->cacheEnabled;
    }

    public function write(array $item, $entity)
    {
    }
}