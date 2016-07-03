<?php
namespace michaeljamesparsons\DataImporter\Writers;

use michaeljamesparsons\DataImporter\Cache\AbstractCacheDriver;
use michaeljamesparsons\DataImporter\Context\AbstractDatabaseSourceContext;
use michaeljamesparsons\DataImporter\Context\DatabaseEntityContext;

/**
 * Class AbstractDatabaseWriter
 * @package michaeljamesparsons\DataImporter\Writers
 */
abstract class AbstractDatabaseWriter extends AbstractSourceWriter
{
    /**
     * The number of items imported.
     *
     * @var int
     */
    protected $count;

    /**
     * The number of records to save at one time.
     *
     * @var int
     */
    protected $bundleSize;

    /**
     * If true, the database tables will be truncated before executing the import.
     *
     * @var  bool
     */
    protected $truncate;

    /**
     * AbstractDatabaseWriter constructor.
     *
     * @param AbstractDatabaseSourceContext $context
     * @param int                           $bundleSize
     * @param AbstractCacheDriver           $cache
     */
    public function __construct(
        AbstractDatabaseSourceContext $context,
        $bundleSize = 300,
        AbstractCacheDriver $cache = null
    ) {
        parent::__construct($context, $cache);

        //This is here for IDE code completion purposes.
        /** @var AbstractDatabaseSourceContext context */
        $this->context    = $context;
        $this->bundleSize = $bundleSize;
        $this->count      = 0;
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
        if ($this->truncate) {
            $this->context->truncateTable();
        }
    }

    /**
     * @inheritdoc
     */
    public function after()
    {
        $this->context->flush();
    }

    /**
     * Fetch an existing record or create a new one if it does not already exist.
     *
     * @param DatabaseEntityContext $entityContext
     * @param array                 $item
     *
     * @return array
     */
    protected function findOrCreateIfNotExists(DatabaseEntityContext $entityContext, array $item)
    {
        /**
         * Check if the record has already been imported by its primary keys.
         */
        $entity = $this->cache->find(
            $this->cache->hashDictionary($entityContext->getPrimaryKeyValues($item))
        );

        /**
         * Check if a duplicate record has already been imported by its index fields.
         */
        if (empty($entity)) {
            $entity = $this->cache->find(
                $this->cache->hashDictionary($entityContext->getIndexFieldValues($item))
            );
        }

        /**
         * The record is not in the cache. Check if a duplicate exists in the database.
         *
         * If the index fields are empty, or a duplicate record does not already exist, a new entity will be returned.
         */
        if (empty($entity)) {
            $entity = $this->context->findOrCreateIfNotExists($entityContext, $item);
        }

        /**
         * Record does not exist in cache or database. Create a new object serialized as
         * an associative array.
         */
        if (empty($entity)) {
            $entity = $entityContext->createObjectAsArray();
        }

        return $entity;
    }
}