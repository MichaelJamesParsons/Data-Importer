<?php
namespace michaeljamesparsons\DataImporter\Context;

/**
 * Class ForeignKeyContext
 * @package michaeljamesparsons\DataImporter\Context
 */
class ForeignKeyContext
{
	const TYPE_ONE_TO_ONE   = 1;
	const TYPE_ONE_TO_MANY  = 2;
	const TYPE_MANY_TO_ONE  = 3;
	const TYPE_MANY_TO_MANY = 4;

	/** @var  string */
	protected $sourceProperty;

	/** @var  string */
	protected $targetObject;

	/** @var  string */
	protected $type;

	/**
	 * @return string
	 */
	public function getSourceProperty()
	{
		return $this->sourceProperty;
	}

	/**
	 * @param string $sourceProperty
	 *
	 * @return $this
	 */
	public function setSourceProperty($sourceProperty)
	{
		$this->sourceProperty = $sourceProperty;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getTargetObject()
	{
		return $this->targetObject;
	}

	/**
	 * @param string $targetObject
	 *
	 * @return $this
	 */
	public function setTargetObject($targetObject)
	{
		$this->targetObject = $targetObject;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getType()
	{
		return $this->type;
	}

	/**
	 * @param string $type
	 *
	 * @return $this
	 * @throws \Exception
	 */
	public function setType($type)
	{
		if(!in_array($type, [
			self::TYPE_ONE_TO_ONE,
		    self::TYPE_ONE_TO_MANY,
		    self::TYPE_MANY_TO_ONE,
		    self::TYPE_MANY_TO_MANY])) {
			throw new \Exception("Invalid foreign key type {$type}.");
		}

		$this->type = $type;
		return $this;
	}
}