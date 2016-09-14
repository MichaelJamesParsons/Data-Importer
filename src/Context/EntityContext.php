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
     * ORM oriented database writers should provide the fully qualified namespace of the entity they intend to import.
     * Non-ORM contexts that directly interact with the database should set this value to the name of the table.
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
     * A list of AbstractAssociation objects which define the entity's foreign key relationships.
     *
     * These relationships must be defined in order to import relationships between multiple entities.
     *
     * @var  AbstractAssociation[]
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
     * If true, the import will check if a duplicate record already exists.
     *
     * See the $canUpdateDuplicates property below to determine what happens when a duplicate is found.
     *
     * Default: true
     *
     * @var bool
     */
    protected $canCheckForDuplicates;

    /**
     * If true, when an existing record is found, the import will update that record with the values found in the
     * item being imported. If false, the record will be skipped in an existing record is found.
     *
     * Important: If $canCheckForDuplicates is set to false, the value of this property will become irrelevant,
     * because the import won't search for duplicate records.
     *
     * Default: false
     *
     * @var bool
     */
    protected $canUpdateDuplicates;

    /**
     * If true, when an existing record is being updated, any missing or empty fields in the imported item will be
     * set to null in the existing record. If false, the missing or empty fields in the imported item will not
     * affect the existing values in the duplicate record.
     *
     * Default: true
     *
     * @var bool
     */
    protected $canSaveEmptyFields;

    /**
     * If true, the old and new primary key of each of this entity's records will be stored in a cache, which other
     * entities may reference to connect relationships between each other.
     *
     * @var boolean
     */
    protected $canCache;

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
        $this->name                 = $name;
        $this->fields               = $fields;
        $this->associations         = $associations;
        $this->indexFields          = $indexFields;
        $this->checkForDuplicates   = true;
        $this->canUpdateDuplicates  = false;
        $this->canSaveEmptyFields   = true;
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
     * @param $name
     *
     * @return $this
     */
    public function addField($name) {
        $this->fields[] = $name;

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
     * @param AbstractAssociation $association
     *
     * @return $this
     */
    public function addAssociation(AbstractAssociation $association)
    {
        $this->associations[] = $association;

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
    public function setIndexFields(array $indexFields)
    {
        $this->indexFields = $indexFields;

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
     * @return bool
     */
    public function canCheckForDuplicates() {
       return $this->checkForDuplicates;
    }

    /**
     * @param bool $check
     *
     * @return $this
     */
    public function setCheckForDuplicates($check) {
        $this->checkForDuplicates = $check;

        return $this;
    }

    /**
     * @return bool
     */
    public function canUpdateDuplicates() {
        return $this->canUpdateDuplicates;
    }

    /**
     * @param $canUpdate
     *
     * @return $this
     */
    public function setUpdateDuplicates($canUpdate) {
        $this->canUpdateDuplicates = $canUpdate;

        return $this;
    }

    /**
     * @return bool
     */
    public function canSaveEmptyFields() {
        return $this->canSaveEmptyFields;
    }

    /**
     * @param $canSave
     *
     * @return $this
     */
    public function setSaveEmptyFields($canSave) {
        $this->canSaveEmptyFields = $canSave;

        return $this;
    }

    /**
     * @return boolean
     */
    public function canCache()
    {
        return $this->canCache;
    }

    /**
     * @param boolean $canCache
     *
     * @return $this
     */
    public function setCanCache($canCache)
    {
        $this->canCache = $canCache;

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