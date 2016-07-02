<?php
namespace michaeljamesparsons\DataImporter\Context;

/**
 * Class AbstractDatabaseContext
 * @package michaeljamesparsons\DataImporter\Context
 */
abstract class AbstractDatabaseContext extends AbstractSourceWriterContext
{
	/**
	 * AbstractDatabaseContext constructor.
	 */
	public function __construct()
	{
        parent::__construct();
	}

    /**
     * @inheritdoc
     */
    public function addEntity(DatabaseEntityContext $context)
    {
        return parent::addEntity($context);
    }

    /**
	 * Finds an existing database record or creates a new record if it does not already exist.
	 *
	 * @param DatabaseEntityContext $context - The context that represents the table or entity.
	 * @param array $fields                    - A list of key/value pairs, where the key is the name of a table column
	 *                                           or entity property. The key must exist in the $indexFields array.
	 *
	 * @return mixed - Returns an object or an array which represents a record in the database.
	 */
	public abstract function findOrCreateIfNotExists(DatabaseEntityContext $context, array $fields);

    /**
     * Turn on database query logging.
     */
    public abstract function enableDatabaseLogging();

    /**
     * Turn off database query logging.
     */
    public abstract function disableDatabaseLogging();

    /**
     * Truncate the table associated with the records being imported.
     */
    public abstract function truncateTable();

    /**
     * Add parsed item to the bundle to be saved.
     *
     * @param $item - The record or entity to be persisted.
     */
    public abstract function persist($item);

    /**
     * Save a bundle of records.
     */
    public abstract function flush();
}