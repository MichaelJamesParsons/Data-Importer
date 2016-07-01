<?php
namespace michaeljamesparsons\DataImporter\Context;

use \Exception;

/**
 * Class AbstractDatabaseContext
 * @package michaeljamesparsons\DataImporter\Context
 */
abstract class AbstractDatabaseContext
{
	/**
	 * A list of DatabaseEntityContext objects.
	 *
	 * These objects define the tables or entities (for ORMs) that will be imported, and the relationships
	 * between them.
	 *
	 * @var array
	 */
	protected $entityContexts;

	/**
	 * AbstractDatabaseContext constructor.
	 *
	 * @param array $entityContexts
	 */
	public function __construct(array $entityContexts = [])
	{
		$this->entityContexts = $entityContexts;
	}

	/**
	 * Finds an entity context with the given name.
	 *
	 * @param $name
	 *
	 * @return DatabaseEntityContext
	 * @throws Exception
	 */
	public function getEntityContext($name) {
		/** @var DatabaseEntityContext $context */
		foreach($this->entityContexts as $context) {
			if($context->getName() == $name) {
				return $context;
			}
		}

		throw new Exception('Entity context "' . $name . '" not defined in database context.');
	}

	/**
	 * Adds an entity context.
	 *
	 * @param DatabaseEntityContext $context
	 *
	 * @return $this
	 * @throws \Exception
	 */
	public function addEntityContext(DatabaseEntityContext $context) {
		try {
			$this->getEntityContext($context->getName());
		} catch(Exception $e) {
			 //An exception is thrown when the context does not exist.
			$this->entityContexts[] = $context;
			return $this;
		}

		throw new Exception('Entity context "' . $context->getName() . '" has already been defined in 
								this database context.');
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
}