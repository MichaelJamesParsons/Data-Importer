<?php
namespace michaeljamesparsons\DataImporter\Workflows;

use michaeljamesparsons\DataImporter\Readers\AbstractReader;
use michaeljamesparsons\DataImporter\Reporters\ReporterInterface;
use michaeljamesparsons\DataImporter\Reporters\Report;
use michaeljamesparsons\DataImporter\Writers\AbstractWriter;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;

/**
 * Class AbstractWorkflow
 * @package michaeljamesparsons\DataImporter\Workers
 */
abstract class AbstractWorkflow implements LoggerAwareInterface
{
    /** @var  array */
    protected $writers;

    /** @var  array */
    protected $readers;

    /** @var  LoggerAwareInterface */
    protected $logger;

    /** @var  ReporterInterface */
    protected $reporter;

    /** @var bool */
    protected $skipRecordOnError;

    /**
     * AbstractWorkflow constructor.
     */
    public function __construct()
    {
        $this->readers           = [];
        $this->writers           = [];
        $this->skipRecordOnError = true;

        /**
         * Logging is optional. By default, the NullLogger is used so that all log requests are thrown away.
         * You can set a logger to enable this feature using the setLogger() method.
         */
        $this->logger = new NullLogger();

        /**
         * This is the default reporter. For additional flexibility, you can set your own reporter using the
         * setReporter() method.
         */
        $this->reporter = new Report();
    }

    /**
     * @param bool $skip
     *
     * @return $this
     */
    public function skipRecordOnError($skip = true)
    {
        $this->skipRecordOnError = $skip;

        return $this;
    }

    /**
     * @param AbstractReader $reader
     *
     * @return $this
     */
    public function addReader(AbstractReader $reader)
    {
        $this->readers[] = $reader;

        return $this;
    }

    /**
     * @param AbstractWriter $writer
     *
     * @return $this
     */
    public function addWriter(AbstractWriter $writer)
    {
        $this->writers[] = $writer;

        return $this;
    }

    /**
     * @param LoggerInterface $logger
     * @return $this
     */
    public function setLogger(LoggerInterface $logger)
    {
        $this->logger = $logger;
        
        return $this;
    }

    /**
     * @param ReporterInterface $reporter
     * @return $this
     */
    public function setReporter(ReporterInterface $reporter)
    {
        $this->reporter = $reporter;
        
        return $this;
    }

    /**
     * Imports the data from each reader into the writers and returns a report when complete.
     *
     * @return Report
     */
    protected abstract function process();
}
