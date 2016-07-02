<?php
namespace michaeljamesparsons\DataImporter\Context;

use Exception;

/**
 * Class AbstractSourceWriterContext
 * @package michaeljamesparsons\DataImporter\Context
 */
class AbstractSourceWriterContext
{
    /**
     * A list of EntityContext objects.
     *
     * @var array
     */
    protected $entities;

    /**
     * AbstractSourceWriterContext constructor.
     */
    public function __construct()
    {
        $this->entities = [];
    }

    /**
     * Finds an entity context with the given name.
     *
     * @param $name
     *
     * @return EntityContext
     * @throws Exception
     */
    public function getEntityContext($name) {
        /** @var EntityContext $context */
        foreach($this->entities as $context) {
            if($context->getName() == $name) {
                return $context;
            }
        }

        throw new Exception('Entity context "' . $name . '" not defined in database context.');
    }

    /**
     * @param EntityContext $context
     *
     * @return $this
     * @throws \Exception
     */
    public function addEntity(EntityContext $context) {
        try {
            $this->getEntityContext($context->getName());
        } catch(Exception $e) {
            //An exception is thrown when the context does not exist.
            $this->entities[] = $context;
            return $this;
        }

        throw new Exception('Entity context "' . $context->getName() . '" has already been defined in this context.');
    }

    /**
     * @param array $entities
     */
    public function setEntities($entities)
    {
        $this->entities = $entities;
    }
}