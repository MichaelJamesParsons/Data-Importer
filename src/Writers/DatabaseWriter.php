<?php
namespace michaeljamesparsons\DataImporter\Writers;

use michaeljamesparsons\DataImporter\Context\DatabaseEntityContext;

/**
 * Class DatabaseWriter
 * @package michaeljamesparsons\DataImporter\Writers
 */
class DatabaseWriter extends AbstractDatabaseWriter
{
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
        $entityContext = $this->context->getEntityContext($entity);
        $record = $this->mapItemValuesToRecordKeys(
            $entityContext,
            $item,
            $this->findOrCreateIfNotExists($entityContext, $item)
        );

        $this->context->persist($entityContext, $record);

        if($this->count != 0 && $this->count % 100 == 0) {
            $this->context->flush();
        }

        $this->count++;
    }

    protected function primaryKeysHaveValues(DatabaseEntityContext $context, array $record) {
        foreach($context->getPrimaryKeyValues($record) as $key => $value) {
            if(!empty($value)) {
                return false;
            }
        }

        return true;
    }

    protected function mapItemValuesToRecordKeys(DatabaseEntityContext $context, array $item, array $record) {
        foreach($item as $property => $value) {
            if(array_key_exists($property, $record)) {
                $record[$property] = $value;
            }
        }

        return $record;
    }
}