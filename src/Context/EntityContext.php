<?php
namespace michaeljamesparsons\DataImporter\Context;

/**
 * Class EntityContext
 * @package michaeljamesparsons\DataImporter\Context
 */
class EntityContext
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
     * A list of foreign key relationships.
     *
     * These relationships must be defined in order to import records that are related to each other in a
     * single import.
     *
     * @var  array
     */
    protected $associations;

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
	 * EntityContext constructor.
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
    public function getAssociations()
    {
        return $this->associations;
    }

    /**
     * @param array $associations
     *
     * @return $this
     */
    public function setAssociations($associations)
    {
        $this->associations = $associations;
        return $this;
    }

    /**
     * @param Association $association
     *
     * @return $this
     */
    public function addAssociation(Association $association) {
        $this->associations[] = $association;
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