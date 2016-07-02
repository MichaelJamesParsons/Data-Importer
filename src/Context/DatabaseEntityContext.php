<?php
namespace michaeljamesparsons\DataImporter\Context;

/**
 * Class DatabaseEntityContext
 * @package michaeljamesparsons\DataImporter\Context
 */
class DatabaseEntityContext extends ObjectContext
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
	 * @var  bool
	 */
	protected $importablePrimaryKey;

	/**
	 * A list of foreign key relationships.
	 *
	 * These relationships must be defined in order to import records that are related to each other in a
	 * single import.
	 *
	 * @var  array
	 *
	 * @todo Make foreign key object.
	 * @todo Create an "addForeignKey" method.
	 */
	protected $foreignKeys;

	/**
	 * DatabaseEntityContext constructor.
	 *
	 * @param string $name
	 * @param string $primaryKey
	 * @param array  $foreignKeys
	 * @param array  $indexFields
	 */
	public function __construct($name, $primaryKey, array $foreignKeys = [], array $indexFields = [])
	{
		parent::__construct($name);

		$this->primaryKey  = $primaryKey;
		$this->foreignKeys = $foreignKeys;
		$this->indexFields = $indexFields;
	}

	/**
	 * @return string
	 */
	public function getPrimaryKey()
	{
		return $this->primaryKey;
	}

	/**
	 * @param string $primaryKey
	 *
	 * @return $this
	 */
	public function setPrimaryKey($primaryKey)
	{
		$this->primaryKey = $primaryKey;
		return $this;
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
	 * @return array
	 */
	public function getForeignKeys()
	{
		return $this->foreignKeys;
	}

	/**
	 * @param array $foreignKeys
	 *
	 * @return $this
	 */
	public function setForeignKeys($foreignKeys)
	{
		$this->foreignKeys = $foreignKeys;
		return $this;
	}
}