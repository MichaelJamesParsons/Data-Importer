<?php
namespace michaeljamesparsons\DataImporter\Helpers;

/**
 * Class EntityRelationship
 * @package michaeljamesparsons\DataImporter\Helpers
 */
class EntityRelationship
{
    const RELATIONSHIP_ONE_TO_ONE = 1;
    const RELATIONSHIP_ONE_TO_MANY = 2;
    const RELATIONSHIP_MANY_TO_ONE = 3;
    const RELATIONSHIP_MANY_TO_MANY = 4;

    /** @var  string */
    protected $property;

    /** @var  string */
    protected $entity;

    /** @var  string */
    protected $relationship;

    public function __construct($entity, $property, $relationship)
    {
        $this->entity       = $entity;
        $this->property     = $property;
        $this->relationship = $relationship;
    }

    /**
     * @return string
     */
    public function getProperty()
    {
        return $this->property;
    }

    /**
     * @param string $property
     *
     * @return $this
     */
    public function setProperty($property)
    {
        $this->property = $property;

        return $this;
    }

    /**
     * @return string
     */
    public function getEntity()
    {
        return $this->entity;
    }

    /**
     * @param string $entity
     *
     * @return $this
     */
    public function setEntity($entity)
    {
        $this->entity = $entity;

        return $this;
    }

    /**
     * @return string
     */
    public function getRelationship()
    {
        return $this->relationship;
    }

    /**
     * @param string $type
     *
     * @return $this
     * @throws \Exception
     */
    public function setRelationship($type)
    {
        if (!in_array($type, [
            self::RELATIONSHIP_ONE_TO_ONE,
            self::RELATIONSHIP_ONE_TO_MANY,
            self::RELATIONSHIP_MANY_TO_ONE,
            self::RELATIONSHIP_MANY_TO_MANY
        ])
        ) {
            throw new \Exception("Invalid relationship type \"{$type}\".");
        }

        $this->relationship = $type;

        return $this;
    }
}