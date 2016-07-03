<?php
namespace michaeljamesparsons\DataImporter\Importers;

use michaeljamesparsons\DataImporter\Readers\AbstractReader;
use michaeljamesparsons\DataImporter\Writers\AbstractWriter;


/**
 * Class GenericImporter
 * @package michaeljamesparsons\DataImporter\Importers
 */
class GenericImporter extends AbstractImporter
{
    /** @var  array */
    protected $readers;

    /** @var  array */
    protected $writers;

    public function __construct()
    {
        parent::__construct();
        $this->readers = [];
        $this->writers = [];
    }

    /**
     * @return array
     */
    public function getReaders()
    {
        return $this->readers;
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
     * @return array
     */
    public function getWriters()
    {
        return $this->writers;
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
}