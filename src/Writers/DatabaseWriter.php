<?php
namespace michaeljamesparsons\DataImporter\Writers;

use michaeljamesparsons\DataImporter\Cache\AbstractCacheDriver;
use michaeljamesparsons\DataImporter\Context\AbstractDatabaseSourceContext;
use michaeljamesparsons\DataImporter\Context\DatabaseEntityContext;

/**
 * Class DatabaseWriter
 * @package michaeljamesparsons\DataImporter\Writers
 *
 * @todo - Refactor database entity caching to handle only a single incremental ID. Composite keys don't need to be stored.
 */
class DatabaseWriter extends AbstractDatabaseWriter
{
    public function __construct(AbstractDatabaseSourceContext $context, $bundleSize, AbstractCacheDriver $cache = null
    ) {
        parent::__construct($context, $bundleSize, $cache);

        //This is here for IDE code completion purposes.
        /** @var AbstractDatabaseSourceContext context */
        $this->context = $context;
    }

    /**
     * Import a single item.
     *
     * @param array  $item - The item to import.
     * @param string $entity
     *
     * @throws \Exception
     */
    public function write(array $item, $entity)
    {
        /** @var DatabaseEntityContext $entityContext */
        $entityContext = $this->context->getEntityContext($entity);

        /** @var array $record */
        $record = $this->mapItemValuesToRecordKeys(
            $item,
            $this->findOrCreateIfNotExists($entityContext, $item)
        );

        $this->persist($entityContext, $record);

        if (true || $this->count != 0 && $this->count % 100 == 0) {
            $this->flush();
        }

        $this->count++;
    }

    protected function mapItemValuesToRecordKeys(array $item, array $record)
    {
        foreach ($item as $property => $value) {
            if (array_key_exists($property, $record)) {
                $record[$property] = $value;
            }
        }

        return $record;
    }

    /**
     * @param \michaeljamesparsons\DataImporter\Context\DatabaseEntityContext $context
     * @param array                                                           $record
     *
     * @return bool
     * @deprecated
     */
    protected function primaryKeysHaveValues(DatabaseEntityContext $context, array $record)
    {
        foreach ($context->getPrimaryKeyValues($record) as $key => $value) {
            if (!empty($value)) {
                return false;
            }
        }

        return true;
    }

    protected function persist(DatabaseEntityContext $context, array $record) {
        $this->context->persist($context, $record);
        $this->cache->add($context->getName(), $record[$context->getPrimaryKey()], null);
    }

    protected function flush() {
        $savedEntities = $this->context->flush();

        foreach($savedEntities as $name => $keys) {
            foreach($keys as $old => $new) {
                $this->cache->update($name, $old, $new);
            }
        }
    }
}