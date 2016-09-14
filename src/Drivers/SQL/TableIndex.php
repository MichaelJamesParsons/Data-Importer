<?php
namespace michaeljamesparsons\DataImporter\Drivers\SQL;

/**
 * Class TableIndex
 * @package michaeljamesparsons\DataImporter\Drivers\SQL
 *
 * @todo - Save table indexes to file and build recovery procedure
 *         to restore the indexes if the import crashes before they
 *         are restored.
 */
class TableIndex
{
    /** @var  string */
    protected $table;

    /** @var  array */
    protected $fields;

    public function __construct($table, array $fields = [])
    {
        $this->table = $table;
        $this->fields = $fields;
    }

    /**
     * @return string
     */
    public function getTable()
    {
        return $this->table;
    }

    /**
     * @param string $table
     *
     * @return $this
     */
    public function setTable($table)
    {
        $this->table = $table;

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
     * @param string $field
     *
     * @return $this
     */
    public function addField($field)
    {
        $this->fields[] = $field;

        return $this;
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
}