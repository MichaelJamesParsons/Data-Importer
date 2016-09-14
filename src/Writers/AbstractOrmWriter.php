<?php
namespace michaeljamesparsons\DataImporter\Writers;

use michaeljamesparsons\DataImporter\Context\AbstractAssociation;
use michaeljamesparsons\DataImporter\Context\DatabaseEntityContext;

/**
 * Class AbstractOrmWriter
 * @package michaeljamesparsons\DataImporter\Writers
 */
abstract class AbstractOrmWriter extends AbstractDatabaseWriter
{
    /**
     * @param DatabaseEntityContext $context
     * @param array                 $record
     *
     * @return object
     */
    protected function mapRecordKeysToEntityProperties(DatabaseEntityContext $context, array $record)
    {
        $reflection = new \ReflectionClass($context->getName());
        $entity     = $reflection->newInstanceWithoutConstructor();

        foreach ($record as $property => $value) {
            $reflectionProperty = $reflection->getProperty($property);

            if($property == $context->getPrimaryKey()) {
                continue;
            }

            /** @var AbstractAssociation $association */
            foreach ($context->getAssociations() as $association) {
                if ($association->getSourceProperty() == $property) {
                    if (in_array($association->getType(),
                        [AbstractAssociation::TYPE_ONE_TO_MANY, AbstractAssociation::TYPE_MANY_TO_MANY])) {
                        $method = sprintf('add%s', ucwords($property));
                    } else {
                        $method = sprintf('set%s', ucwords($property));
                    }

                    if(method_exists($entity, $method)) {
                        call_user_func([$entity, $method], $this->getAssociatedEntity(
                            $association->getTargetObject(),
                            $value
                        ));
                    } else {
                        continue 2;
                    }
                }
            }

            $reflectionProperty->setAccessible(true);
            $reflectionProperty->setValue($entity, $value);
        }

        return $entity;
    }

    /**
     * @param $objectName
     * @param $value
     *
     * @return mixed
     * @throws \Exception
     */
    protected function getAssociatedEntity($objectName, $value) {
        /** @var DatabaseEntityContext $context */
        $context = $this->getEntityContext($objectName);

        if(!is_array($value)) {
            $entity = $this->cache->find($context->getName(), $value);

            if(!empty($entity) && !empty($entity[$context->getPrimaryKey()])) {
                $reference = $this->getEntityReference($context, $entity[$context->getPrimaryKey()]);
            } else {
                $reference = $this->persist($context, $entity);
            }
        } else {
            $reference = $this->getEntityReference($objectName, $value);
        }

        return $reference;
    }

    /**
     * @param DatabaseEntityContext $context
     * @param                       $primaryKey
     *
     * @return mixed
     */
    protected abstract function getEntityReference(DatabaseEntityContext $context, $primaryKey);
}