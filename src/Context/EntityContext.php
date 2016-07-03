<?php
namespace michaeljamesparsons\DataImporter\Context;

/**
 * Class EntityContext
 * @package michaeljamesparsons\DataImporter\Context
 */
class EntityContext
{
    /**
     * The name of the object.
     *
     * ORM oriented database contexts should provide the fully qualified namespace of the entity they intend to import.
     * Contexts that directly interact with the database without an ORM should set this value to the name of the table.
     *
     * @var  string
     */
    protected $name;

    /**
     * The expected fields associated with this entity.
     *
     * @var array
     */
    protected $fields;

    /**
     * A list of foreign key relationships.
     *
     * These relationships must be defined in order to import records that are related to each other in a
     * single import.
     *
     * @var  array
     */
    protected $associations;

    /**
     * This is a list of fields that can be used to uniquely identify a record. The importer will use these fields
     * to check if this record already exists inside of the cache (and database if applicable) before writing it.
     *
     * When checking the cache, the importer will search for a matching record whose fields contain the exact
     * values in ALL of the index fields. When working with database imports, incremental primary keys should NOT
     * be included in this list.
     *
     * @var  array
     */
    protected $indexFields;

    /**
     * EntityContext constructor.
     *
     * @param string $name
     * @param array  $fields
     * @param array  $associations
     * @param array  $indexFields
     */
    public function __construct($name, array $fields = [], array $associations = [], array $indexFields = [])
    {
        $this->name         = $name;
        $this->fields       = $fields;
        $this->associations = $associations;
        $this->indexFields  = $indexFields;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return $this
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return array
     */
    public function getFields()
    {
        return $this->fields;
    }

    /**
     * @param array $fields
     *
     * @return $this
     */
    public function setFields($fields)
    {
        $this->fields = $fields;

        return $this;
    }

    /**
     * @return array
     */
    public function getAssociations()
    {
        return $this->associations;
    }

    /**
     * @param array $associations
     *
     * @return $this
     */
    public function setAssociations($associations)
    {
        $this->associations = $associations;

        return $this;
    }

    /**
     * @param Association $association
     *
     * @return $this
     */
    public function addAssociation(Association $association)
    {
        $this->associations[] = $association;

        return $this;
    }

    /**
     * @param $field
     *
     * @return $this
     */
    public function addIndexField($field)
    {
        $this->indexFields[] = $field;

        return $this;
    }

    /**
     * Maps the values from the item to the index fields defined in the entity context.
     *
     * @param array $item
     *
     * @return array
     */
    public function getIndexFieldValues($item)
    {
        $indexes = [];

        foreach ($this->getIndexFields() as $index) {
            if (array_key_exists($index, $item) && !empty($item[$index])) {
                $indexes[$index] = $item[$index];
            }
        }

        return $indexes;
    }

    /**
     * @return array
     */
    public function getIndexFields()
    {
        return $this->indexFields;
    }

    /**
     * @param array $indexFields
     *
     * @return $this
     */
    public function setIndexFields($indexFields)
    {
        $this->indexFields = $indexFields;

        return $this;
    }

    /**
     * Returns an associative array where the keys are the entity's fields, and the values are null.
     *
     * @return array
     */
    public function createObjectAsArray()
    {
        $object = [];

        foreach ($this->fields as $field) {
            $object[$field] = null;
        }

        return $object;
    }
}