<?php
namespace michaeljamesparsons\DataImporter\Helpers;

/**
 * Class EntityMapper
 * @package michaeljamesparsons\DataImporter\Helpers
 */
class EntityMapper
{
    /** @var  string */
    protected $entity;

    /** @var  string */
    protected $primaryKey;

    /** @var  bool */
    protected $importablePrimaryKey;

    /** @var  array */
    protected $relationships;

    /** @var  array */
    protected $properties;

    /** @var  array */
    protected $setters;

    /** @var  array */
    protected $lookupFields;

    /**
     * EntityMapper constructor.
     *
     * @param              $entity
     * @param null         $primaryKey
     * @param array        $relationships
     */
    public function __construct($entity, $primaryKey, array $relationships = [])
    {
        $this->entity               = $entity;
        $this->setters              = [];
        $this->relationships        = [];
        $this->lookupFields         = [];
        $this->primaryKey           = $primaryKey;
        $this->properties           = $this->parseProperties($entity);
        $this->importablePrimaryKey = false;

        /** @var EntityRelationship $relationship */
        foreach ($relationships as $relationship) {
            $this->addRelationship($relationship);
        }
    }

    /**
     * @param $entity
     *
     * @return array
     */
    public function parseProperties($entity)
    {
        $properties = [];
        $reflection = new \ReflectionClass($entity);

        /** @var \ReflectionProperty $property */
        foreach ($reflection->getProperties() as $property) {
            $properties[] = $property->getName();
        }

        return $properties;
    }

    /**
     * @param EntityRelationship $relationship
     *
     * @return $this
     */
    public function addRelationship(EntityRelationship $relationship)
    {
        $this->relationships[$relationship->getProperty()] = $relationship;

        return $this;
    }

    /**
     * @return string
     */
    public function getEntity()
    {
        return $this->entity;
    }

    /**
     * @param $entity
     *
     * @return $this
     */
    public function setEntity($entity)
    {
        $this->entity = $entity;

        return $this;
    }

    /**
     * @return array
     */
    public function getRelationships()
    {
        return $this->relationships;
    }

    public function findRelationship($property)
    {
        return $this->relationships[$property];
    }

    /**
     * @return array
     */
    public function getProperties()
    {
        return $this->properties;
    }

    /**
     * @return array
     */
    public function getSetters()
    {
        return $this->setters;
    }

    /**
     * @param $property
     * @param $function
     */
    public function addSetter($property, $function)
    {
        $this->setters[$property] = $function;
    }

    /**
     * Add a field to search for record by to ensure that data is unique.
     *
     * @param $field
     *
     * @return $this
     * @throws \Exception
     */
    public function addLookupField($field)
    {
        if (in_array($field, $this->properties)) {
            $this->lookupFields[] = $field;

            return $this;
        }

        throw new \Exception("Invalid Lookup field \"{$field}\". Property does not exist in class {$this->entity}.");
    }

    /**
     * @return array
     */
    public function getLookupFields()
    {
        return $this->lookupFields;
    }

    /**
     * @return bool
     */
    public function hasImportablePrimaryKey()
    {
        return $this->importablePrimaryKey;
    }

    /**
     * @param $doImport
     */
    public function importPrimaryKey($doImport)
    {
        $this->importablePrimaryKey = $doImport;
    }

    /**
     * @param $property
     *
     * @return string
     */
    public function getPropertySetter($property)
    {
        if (array_key_exists($property, $this->setters)) {
            return $this->setters[$property];
        } elseif (array_key_exists($property, $this->relationships)
                  && $this->relationships[$property] != EntityRelationship::RELATIONSHIP_ONE_TO_ONE
        ) {
            $setter = $this->convertPropertyMethod('add', $property);
        } else {
            $setter = $this->convertPropertyMethod('set', $property);
        }

        $this->setters[$property] = $setter;

        return $setter;
    }

    /**
     * @param $prefix
     * @param $property
     *
     * @return string
     */
    protected function convertPropertyMethod($prefix, $property)
    {
        $parts  = explode('_', $property);
        $method = $prefix;

        foreach ($parts as $part) {
            $method .= ucwords($part);
        }

        return $method;
    }

    /**
     * @return string
     */
    public function getPrimaryKeyGetter()
    {
        return $this->getPropertyGetter($this->getPrimaryKey());
    }

    /**
     * @param $property
     *
     * @return string
     */
    public function getPropertyGetter($property)
    {
        return $this->convertPropertyMethod('get', $property);
    }

    /**
     * @return string
     */
    public function getPrimaryKey()
    {
        return $this->primaryKey;
    }

    /**
     * @param string $primaryKey
     */
    public function setPrimaryKey($primaryKey)
    {
        $this->primaryKey = $primaryKey;
    }
}