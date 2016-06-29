<?php
namespace michaeljamesparsons\DataImporter\Reporters;

use DateTime;

/**
 * Class Report
 * @package michaeljamesparsons\DataImporter\Reporters
 */
class Report
{
	/** @var  \DateTime */
	protected $startTime;

	/** @var  \DateTime */
	protected $endTime;

	/** @var  int */
	protected $importCount;

	/** @var  int */
	protected $errorCount;

	/**
	 * Report constructor.
	 *
	 * @param \DateTime $start
	 * @param \DateTime $end
	 * @param           $count
	 * @param           $errorCount
	 */
	public function __construct(\DateTime $start, \DateTime $end, $count, $errorCount)
	{
		$this->startTime   = $start;
		$this->endTime     = $end;
		$this->importCount = $count;
		$this->errorCount  = $errorCount;
	}

	/**
	 * @return DateTime
	 */
	public function getStartTime()
	{
		return $this->startTime;
	}

	/**
	 * @param DateTime $startTime
	 */
	public function setStartTime($startTime)
	{
		$this->startTime = $startTime;
	}

	/**
	 * @return DateTime
	 */
	public function getEndTime()
	{
		return $this->endTime;
	}

	/**
	 * @param DateTime $endTime
	 */
	public function setEndTime($endTime)
	{
		$this->endTime = $endTime;
	}

	/**
	 * Returns the difference between the start time and end time.
	 * @return \DateInterval
	 */
	public function getTimeElapsed() {
		if(!empty($this->endTime) && !empty($this->startTime)) {
			return null;
		}

		return $this->endTime->diff($this->startTime);
	}

	/**
	 * @return int
	 */
	public function getImportCount()
	{
		return $this->importCount;
	}

	/**
	 * @param int $importCount
	 */
	public function setImportCount($importCount)
	{
		$this->importCount = $importCount;
	}

	/**
	 * Returns the number of records processed in the import.
	 *
	 * @return int
	 */
	public function getProcessedCount() {
		return $this->importCount + $this->errorCount;
	}

	/**
	 * @return int
	 */
	public function getErrorCount()
	{
		return $this->errorCount;
	}

	/**
	 * @param int $errorCount
	 */
	public function setErrorCount($errorCount)
	{
		$this->errorCount = $errorCount;
	}

	public function toArray() {
		return [
			'startTime'      => (!empty($this->startTime)) ? $this->startTime->format('Y-m-d H:m:s') : null,
			'endTime'        => (!empty($this->endTime)) ? $this->endTime->format('Y-m-d H:m:s') : null,
			'timeElapsed'    => (!empty($this->getTimeElapsed())) ? $this->getTimeElapsed()->format('Y-m-d H:m:s') : null,
			'importCount'    => $this->importCount,
		    'errorCount'     => $this->errorCount,
		    'processedCount' => $this->getProcessedCount()
		];
	}
}