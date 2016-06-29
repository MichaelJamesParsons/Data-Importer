<?php
namespace michaeljamesparsons\DataImporter\Importers;

/**
 * Class AbstractImporter
 * @package michaeljamesparsons\DataImporter\Importers
 */
abstract class AbstractImporter
{
	/** @var bool */
	protected $skipRecordOnError;

	public function __construct()
	{
		$this->skipRecordOnError = true;
	}

	/**
	 * @return boolean
	 */
	public function skipRecordOnError()
	{
		return $this->skipRecordOnError;
	}

	/**
	 * @param boolean $skipRecordOnError
	 */
	public function setSkipRecordOnError($skipRecordOnError)
	{
		$this->skipRecordOnError = $skipRecordOnError;
	}
}