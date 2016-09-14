<?php
namespace michaeljamesparsons\DataImporter\Drivers\SQL;

/**
 * Class AbstractSqlDriver
 * @package michaeljamesparsons\DataImporter\Drivers\SQL
 *
 * @todo - Move to SQL Adapter repository.
 */
abstract class AbstractSqlDriver
{
    protected $indexes;

    public function __construct()
    {
        $this->indexes = [];
    }

    public function buildInsertQuery($table, $fields, $table) {}
    public function buildUpdateQuery($table, $fields, $table) {}
    public abstract function findTable($tableName);
    public abstract function disableIndexes($keys);

    /**
     * @return array
     */
    public function getIndexes()
    {
        return $this->indexes;
    }

    public function addIndex($index) {

    }

    /**
     * @param array $indexes
     *
     * @return $this
     */
    public function setIndexes($indexes)
    {
        $this->indexes = $indexes;

        return $this;
    }
}