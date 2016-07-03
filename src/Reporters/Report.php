<?php
namespace michaeljamesparsons\DataImporter\Reporters;

use DateTime;

/**
 * Class Report
 * @package michaeljamesparsons\DataImporter\Reporters
 */
class Report implements ReporterInterface
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
     * @inheritdoc
     */
    public function start()
    {
        $this->startTime   = new DateTime('now');
        $this->endTime     = null;
        $this->importCount = 0;
        $this->errorCount  = 0;
    }

    /**
     * @inheritdoc
     */
    public function stop()
    {
        $this->endTime = new DateTime('now');
    }

    /**
     * @inheritdoc
     */
    public function getStartTime()
    {
        return $this->startTime;
    }

    /**
     * @inheritdoc
     */
    public function getEndTime()
    {
        return $this->endTime;
    }

    /**
     * @inheritdoc
     */
    public function getImportCount()
    {
        return $this->importCount;
    }

    /**
     * @inheritdoc
     */
    public function incrementImportCount()
    {
        $this->importCount++;
    }

    /**
     * @inheritdoc
     */
    public function getErrorCount()
    {
        return $this->errorCount;
    }

    /**
     * @inheritdoc
     */
    public function incrementErrorCount()
    {
        $this->errorCount++;
    }

    /**
     * @return array
     *
     * @todo Consider removing.
     */
    public function toArray()
    {
        return [
            'startTime'      => (!empty($this->startTime)) ? $this->startTime->format('Y-m-d H:m:s') : null,
            'endTime'        => (!empty($this->endTime)) ? $this->endTime->format('Y-m-d H:m:s') : null,
            'timeElapsed'    => (!empty($this->getElapsedTime())) ? $this->getElapsedTime()->format('Y-m-d H:m:s') : null,
            'importCount'    => $this->importCount,
            'errorCount'     => $this->errorCount,
            'processedCount' => $this->getProcessedCount()
        ];
    }

    /**
     * @inheritdoc
     */
    public function getElapsedTime()
    {
        if (!empty($this->endTime) && !empty($this->startTime)) {
            return null;
        }

        return $this->endTime->diff($this->startTime);
    }

    /**
     * @inheritdoc
     */
    public function getProcessedCount()
    {
        return $this->importCount + $this->errorCount;
    }
}