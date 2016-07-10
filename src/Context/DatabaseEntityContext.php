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
     * @todo - Consider removing now that only incremental keys are stored in $primaryKey.
     * @var  bool
     */
    protected $importablePrimaryKey;

    /**
     * DatabaseEntityContext constructor.
     *
     * @param string $name
     * @param string $incrementalPrimaryKey
     * @param array  $fields
     * @param array  $associations
     * @param array  $indexFields
     */
    public function __construct(
        $name,
        $incrementalPrimaryKey = null,
        array $fields = [],
        array $associations = [],
        array $indexFields = []
    ) {
        parent::__construct($name, $fields, $associations, $indexFields);
        $this->primaryKey           = $incrementalPrimaryKey;
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
     * Returns the value of the item's incremental primary key.
     *
     * If the item entity does not have an incremental primary key, a null value will be returned.
     *
     * @param array $item
     *
     * @return array
     */
    public function getPrimaryKeyValue(array $item)
    {
        return (array_key_exists($this->getPrimaryKey(), $item)) ? $item[$this->primaryKey] : null;
    }

    /**
     * @return string
     */
    public function getPrimaryKey()
    {
        return $this->primaryKey;
    }
}