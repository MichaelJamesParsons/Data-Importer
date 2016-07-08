<?php
namespace michaeljamesparsons\DataImporter\Context;

/**
 * Class DatabaseEntityContext
 * @package michaeljamesparsons\DataImporter\Context
 */
class DatabaseEntityContext extends EntityContext
{
    /**
     * The primary key of the table or entity. If the table contains composite primary keys, you should include
     * all of them in the array of $indexFields to prevent importing duplicates.
     *
     * @var  string
     */
    protected $primaryKey;

    /**
     * Determines if the primary key should be included in the import when it is executed.
     *
     * This value should always be set to true when a table contains composite keys that are not incremental.
     *
     * @todo - Refactor usage now that composite primary keys are supported.
     * @var  bool
     */
    protected $importablePrimaryKey;

    /**
     * DatabaseEntityContext constructor.
     *
     * @param string $name
     * @param array  $primaryKeys
     * @param array  $fields
     * @param array  $associations
     * @param array  $indexFields
     */
    public function __construct(
        $name,
        array $primaryKeys,
        array $fields = [],
        array $associations = [],
        array $indexFields = []
    ) {
        parent::__construct($name, $fields, $associations, $indexFields);
        $this->primaryKey           = $primaryKeys;
        $this->importablePrimaryKey = false;
    }

    /**
     * @return boolean
     */
    public function isImportablePrimaryKey()
    {
        return $this->importablePrimaryKey;
    }

    /**
     * @param boolean $importablePrimaryKey
     *
     * @return $this
     */
    public function setImportablePrimaryKey($importablePrimaryKey)
    {
        $this->importablePrimaryKey = $importablePrimaryKey;

        return $this;
    }

    /**
     * Maps the values from the item to the primary keys defined in the entity context.
     *
     * @param array $item
     *
     * @return array
     */
    public function getPrimaryKeyValues(array $item)
    {
        $keys = [];

        foreach ($this->getPrimaryKey() as $index) {
            if (array_key_exists($index, $item)) {
                $keys[$index] = $item[$index];
            }
        }

        return $keys;
    }

    /**
     * @return string
     */
    public function getPrimaryKey()
    {
        return $this->primaryKey;
    }
}