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