<?php
namespace michaeljamesparsons\DataImporter\Writers;

use michaeljamesparsons\DataImporter\Cache\AbstractCacheDriver;
use michaeljamesparsons\DataImporter\Context\DatabaseEntityContext;

/**
 * Class AbstractDatabaseWriter
 * @package michaeljamesparsons\DataImporter\Writers
 */
abstract class AbstractDatabaseWriter extends AbstractRelationalWriter
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
    protected $canTruncate;

    /**
     * AbstractDatabaseWriter constructor.
     *
     * @param int                 $bundleSize
     * @param AbstractCacheDriver $cache
     */
    public function __construct($bundleSize = 300, AbstractCacheDriver $cache = null) {
        parent::__construct($cache);
        $this->bundleSize = $bundleSize;
        $this->count      = 0;
    }

    /**
     * @return boolean
     */
    public function canTruncate() {
        return $this->canTruncate;
    }

    /**
     * @param boolean $truncate
     */
    public function setCanTruncate($truncate) {
        $this->canTruncate = $truncate;
    }

    /**
     * @inheritdoc
     */
    public function before()
    {
        if ($this->canTruncate) {
            $this->truncateTable();
        }
    }

    /**
     * @inheritdoc
     */
    public function after()
    {
        $this->flush();
    }

    public function addEntity(DatabaseEntityContext $context)
    {
        return parent::addEntity($context);
    }

    public function setEntities($entities)
    {
        /** @var DatabaseEntityContext $entity */
        foreach($entities as $entity) {
            if(!($entity instanceof DatabaseEntityContext)) {
                throw new \Exception("Entity context must be of type DatabaseEntityContext.");
            }
        }

        parent::setEntities($entities);
    }

    /**
     * Fetch an existing record or create a new one if it does not already exist.
     *
     * @param DatabaseEntityContext $context
     * @param array                 $item
     *
     * @return RelationalItem
     */
    protected function findOrCreateIfNotExists(DatabaseEntityContext $context, array $item)
    {
        $entity = null;
        if($context->canCheckForDuplicates()) {
            /**
             * Check if the record has already been imported by its primary key.
             */
            $entity = $this->cache->find($context->getName(), $item[$context->getPrimaryKey()]);

            /**
             * The record is not in the cache. Check if a duplicate exists in the database.
             *
             * If the index fields are empty, or a duplicate record does not already exist, a new entity will be returned.
             */
            if (empty($entity)) {
                $entity = $this->findInDatabase($context, $item);

                if(!empty($entity)) {
                    $this->cache->add(
                        $context->getName(),
                        $item[$context->getPrimaryKey()],
                        $entity[$context->getPrimaryKey()]
                    );
                }
            }
        }

        /**
         * Record does not exist in cache or database. Create a new object serialized as
         * an associative array.
         */
        if (empty($entity)) {
            $entity = $context->createObjectAsArray();
        }

        return new RelationalItem($item[$context->getPrimaryKey()], $item, $entity[$context->getPrimaryKey()]);
    }

    /**
     * @param DatabaseEntityContext $context
     * @param array         $item
     *
     * @return array
     */
    protected abstract function findInDatabase(DatabaseEntityContext $context, array $item);

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
     *
     * @todo Move logic to Database entity context.
     */
    protected abstract function truncateTable();

    /**
     * Add parsed item to the bundle to be saved.
     *
     * @param DatabaseEntityContext $context
     * @param RelationalItem        $record - The item to be persisted.
     *
     * @return
     */
    protected abstract function persist(DatabaseEntityContext $context, RelationalItem $record);

    /**
     * Save a bundle of records.
     */
    protected abstract function flush();
}