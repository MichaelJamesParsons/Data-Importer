<?php
namespace michaeljamesparsons\DataImporter\Context;

/**
 * Class DatabaseEntityContext
 * @package michaeljamesparsons\DataImporter\Context
 */
class DatabaseEntityContext
{
	/**
	 * The name of the database table or entity.
	 *
	 * ORM oriented database contexts should provide the fully qualified namespace of the entity they intend to import.
	 * Contexts that directly interact with the database without an ORM should set this value to the name of the table.
	 *
	 * @var  string
	 */
	protected $name;

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
	 * A list of table columns or entity properties that uniquely identify the record in the database.
	 *
	 * These fields uniquely identify records that may already exist in the database. For example, a `categories`
	 * table may contain two fields: `id` and `category_name`. Both fields uniquely identifies the category, but only
	 * the ID makes up the primary key. For imports where category names are expected to also be unique, you would add
	 * `category_name` to this list. Upon importing a new category, the database writer will check if the a category
	 * with that ID already exists before inserting it.
	 *
	 * Incremental primary keys should NOT be included in this list.
	 *
	 * @var  array
	 */
	protected $indexFields;

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
		$this->name        = $name;
		$this->primaryKey  = $primaryKey;
		$this->foreignKeys = $foreignKeys;
		$this->indexFields = $indexFields;
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
	public function setIndexFields($indexFields)
	{
		$this->indexFields = $indexFields;
		return $this;
	}

	/**
	 * @param $field
	 *
	 * @return $this
	 */
	public function addIndexField($field) {
		$this->indexFields[] = $field;
		return $this;
	}
}