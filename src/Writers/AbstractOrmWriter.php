<?php
namespace michaeljamesparsons\DataImporter\Writers;

/**
 * Class AbstractOrmWriter
 * @package michaeljamesparsons\DataImporter\Writers
 */
abstract class AbstractOrmWriter extends AbstractDatabaseWriter
{
	/**
	 * The entity manager for an ORM.
	 */
	protected $context;

	/**
	 * AbstractOrmWriter constructor.
	 *
	 * @param object $context
	 * @param int    $bundleSize
	 */
	public function __construct($context, $bundleSize = 100)
	{
		parent::__construct($bundleSize);
		$this->context = $context;
	}

	/**
	 * @return int
	 */
	public function getCount()
	{
		return $this->count;
	}

	/**
	 * @param int $count
	 *
	 * @return $this
	 */
	public function setCount($count)
	{
		$this->count = $count;
		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getContext()
	{
		return $this->context;
	}

	/**
	 * @param mixed $context
	 *
	 * @return $this
	 */
	public function setContext($context)
	{
		$this->context = $context;
		return $this;
	}
}