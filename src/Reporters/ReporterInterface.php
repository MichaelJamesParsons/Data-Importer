<?php
namespace michaeljamesparsons\DataImporter\Reporters;

/**
 * Interface ReporterInterface
 * @package michaeljamesparsons\DataImporter\Reporters
 */
interface ReporterInterface
{
    /**
     * Initializes the reporter's default values.
     * 
     * @return void
     */
    public function start();

    /**
     * Sets the reporter's end time.
     *
     * May execute additional destruct logic.
     *
     * @return void
     */
    public function stop();

    /**
     * Returns the times at which the report started.
     *
     * @return \DateTime
     */
    public function getStartTime();

    /**
     * Returns the time at which the report ended.
     *
     * @return \DateTime
     */
    public function getEndTime();

    /**
     * Returns the difference between the start time and end time.
     *
     * @return int  - The time difference in seconds.
     */
    public function getElapsedTime();

    /**
     * Returns the number of records that failed to import.
     *
     * @return int
     */
    public function getErrorCount();

    /**
     * Returns the number of records that were successfully imported.
     *
     * @return int
     */
    public function getImportCount();

    /**
     * Returns the number of records processed, including successful and unsuccessful attempts.
     *
     * @return int
     */
    public function getProcessedCount();

    /**
     * Increments the import count by 1.
     *
     * @return void
     */
    public function incrementImportCount();

    /**
     * Increments the error count by 1.
     *
     * @return int
     */
    public function incrementErrorCount();
}