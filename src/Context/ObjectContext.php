<?php
namespace michaeljamesparsons\DataImporter\Context;

/**
 * Class ObjectContext
 * @package michaeljamesparsons\DataImporter\Context
 */
class ObjectContext
{
	/**
	 * The name of the object.
	 *
	 * ORM oriented database contexts should provide the fully qualified namespace of the entity they intend to import.
	 * Contexts that directly interact with the database without an ORM should set this value to the name of the table.
	 *
	 * @var  string
	 */
	protected $name;

	/**
	 * This is a list of fields that can be used to uniquely identify a record. The importer will use these fields
	 * to check if this record already exists inside of the cache (and database if applicable) before writing it.
	 *
	 * When checking the cache, the importer will search for a matching record whose fields contain the exact
	 * values in ALL of the index fields. When working with database imports, incremental primary keys should NOT
	 * be included in this list.
	 *
	 * @var  array
	 */
	protected $indexFields;

	/**
	 * ObjectContext constructor.
	 *
	 * @param $name
	 */
	public function __construct($name)
	{
		$this->name = $name;
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