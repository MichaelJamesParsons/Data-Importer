<?php
namespace michaeljamesparsons\DataImporter\Writers;

use michaeljamesparsons\DataImporter\Cache\AbstractCacheDriver;
use michaeljamesparsons\DataImporter\Context\DatabaseEntityContext;
use PDO;

/**
 * Class SqlDatabaseWriter
 * @package michaeljamesparsons\DataImporter\Writers
 */
class SqlDatabaseWriter extends AbstractDatabaseWriter
{
    /** @var  \PDO */
    protected $pdo;

    /** @var  array */
    protected $insertQueries;

    /** @var  array */
    protected $updateQueries;

    /**
     * SqlDatabaseWriter constructor.
     *
     * @param PDO                 $pdo
     * @param AbstractCacheDriver $cache
     */
    public function __construct(\PDO $pdo, AbstractCacheDriver $cache)
    {
        parent::__construct($cache);
    }

    public function write(array $item, $entity)
    {
        /** @var DatabaseEntityContext $context */
        $context = $this->getEntityContext($entity);

        /** @var RelationalItem $record */
        $record = $this->findOrCreateIfNotExists($context, $item);
        $this->persist($context, $record);

        $this->flush();
    }

    protected function flush() {
        $this->pdo->beginTransaction();

        foreach($this->updateQueries as $table => $statements) {
            foreach($statements as $oldId => $statement) {
                $this->pdo->exec($statement);

                if(!$this->cache->find($table, $oldId)) {
                    $this->cache->add($table, $oldId, $this->pdo->lastInsertId());
                }
            }
        }

        foreach($this->insertQueries as $statement) {
            $this->pdo->exec($statement);
        }

        $this->pdo->commit();
    }

    protected function persist(DatabaseEntityContext $context, RelationalItem $record) {
        if(!empty($record->getImportedId())) {
            if($context->canUpdateDuplicates()) {
                $this->queueForUpdate($context, $record);
            }
        } else {
            $this->queueForInsert($context, $record);
        }
    }

    protected function queueForUpdate(DatabaseEntityContext $context, RelationalItem $item) {
        $this->updateQueries[$context->getName()][$item[$context->getPrimaryKey()]] = $this->buildUpdateQuery(
            $context,
            $item->getValues()
        );
    }

    protected function buildUpdateQuery(DatabaseEntityContext $context, array $item) {
        $fields = $this->getQueryFields($context, $item);
        $placeholders = [];
        foreach($fields as $field => $value) {
            $placeholders[] = $field . ' = ?';
        }

        $this->updateQueries[] = $this->pdo->prepare(sprintf(
            'UPDATE %s SET %s WHERE %s = ?',
            $context->getName(),
            implode(',', $placeholders),
            $context->getPrimaryKey()
        ));
    }

    protected function queueForInsert(DatabaseEntityContext $context, RelationalItem $item) {
        $fields = $this->getQueryFields($context, $item->getValues());
        $values = [];
        foreach($context->getFields() as $column => $value) {
            $values[] = '?';
        }

        if(!array_key_exists($context->getName(), $this->insertQueries)) {
            $this->insertQueries[$context->getName()] = [];
        }

        $query = $this->pdo->prepare(sprintf(
            'INSERT INTO %s (%s) VALUES %s',
            implode(',', $context->getFields()),
            implode(',', $values)
        ));

        foreach($context->getFields() as $index => $column) {
            if(isset($fields[$column])) {
                $query->bindValue($index, $fields[$column], $this->getBindType($fields[$column]));
            } else {
                $query->bindValue($index, null, $this->getBindType(null));
            }
        }

        $this->insertQueries[$context->getName()][] = $query;
    }

    protected function getBindType($value) {
        if(is_int($value)) {
            return PDO::PARAM_INT;
        } elseif(is_bool($value)) {
            return PDO::PARAM_BOOL;
        } elseif(empty($value)) {
            return PDO::PARAM_NULL;
        } else {
            return PDO::PARAM_STR;
        }
    }

    protected function bindParams(\PDOStatement $query, array $fields = []) {
        $x = 0;
        foreach($fields as $field => $value) {
            $query->bindValue($x, $value, $this->getBindType($value));
            $x++;
        }
    }

    protected function getQueryFields(DatabaseEntityContext $context, array $item) {
        $fields = [];
        foreach($context->getFields() as $column) {
            if(array_key_exists($column, $item) && (!empty($item[$column]) || $context->canSaveEmptyFields())) {
                $fields[$column] = $item[$column];
            }
        }

        return $fields;
    }

    protected function findInDatabase(DatabaseEntityContext $context, array $item) {
        $query = $this->pdo->prepare(
            sprintf('SELECT * FROM %s WHERE %s = ?', $context->getName(), $context->getPrimaryKey())
        );

        $query->bindValue(
            1,
            $item[$context->getPrimaryKey()],
            $this->getBindType($item[$context->getPrimaryKey()])
        );

        return $query->fetch(PDO::FETCH_ASSOC);
    }

    protected function mapItemToRecord(array $item, array $record) {

    }

    /**
     * Turn on database query logging.
     */
    protected function enableDatabaseLogging()
    {
        // TODO: Implement enableDatabaseLogging() method.
    }

    /**
     * Turn off database query logging.
     */
    protected function disableDatabaseLogging()
    {
        // TODO: Implement disableDatabaseLogging() method.
    }

    /**
     * Truncate the table associated with the records being imported.
     *
     * @todo Move logic to Database entity context.
     */
    protected function truncateTable()
    {
        // TODO: Implement truncateTable() method.
    }
}