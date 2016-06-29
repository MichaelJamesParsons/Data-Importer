<?php
namespace michaeljamesparsons\DataImporter\Workers;

use michaeljamesparsons\DataImporter\Readers\AbstractReader;
use michaeljamesparsons\DataImporter\Reporters\Report;
use michaeljamesparsons\DataImporter\Writers\AbstractWriter;


/**
 * Class AbstractImportWorker
 * @package michaeljamesparsons\DataImporter\Workers
 */
abstract class AbstractImportWorker
{
	/** @var  \DateTime */
	protected $startTime;

	/** @var  \DateTime */
	protected $endTime;

	/** @var  int */
	protected $importCount;

	/** @var  int */
	protected $errorCount;

	/** @var bool */
	protected $skipRecordOnError;

	/** @var  array */
	protected $writers;

	/** @var  array */
	protected $readers;

	public function __construct()
	{
		$this->readers = [];
		$this->writers = [];
		$this->skipRecordOnError = true;
		$this->errorCount  = 0;
		$this->importCount = 0;
	}

	/**
	 * @param bool $skip
	 *
	 * @return $this
	 */
	public function skipRecordOnError($skip = true) {
		$this->skipRecordOnError = $skip;
		return $this;
	}

	protected function initialize() {
		$this->startTime   = new \DateTime('now');
		$this->importCount = 0;
		$this->errorCount  = 0;
	}
	
	protected function report() {
		return new Report($this->startTime, new \DateTime('now'), $this->importCount, $this->errorCount);
	}

	/**
	 * @param AbstractReader $reader
	 *
	 * @return $this
	 */
	public function addReader(AbstractReader $reader) {
		$this->readers[] = $reader;
		return $this;
	}

	/**
	 * @param AbstractWriter $writer
	 *
	 * @return $this
	 */
	public function addWriter(AbstractWriter $writer) {
		$this->writers[] = $writer;
		return $this;
	}

	protected abstract function process();
}