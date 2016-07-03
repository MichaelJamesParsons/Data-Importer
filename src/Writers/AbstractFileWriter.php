<?php
namespace michaeljamesparsons\DataImporter\Writers;

/**
 * Class AbstractFileWriter
 * @package michaeljamesparsons\DataImporter\Writers
 */
abstract class AbstractFileWriter extends AbstractWriter
{
    /** @var  string */
    protected $filePath;

    /**
     * AbstractFileWriter constructor.
     *
     * @param string $filePath - The absolute path to the file.
     */
    public function __construct($filePath)
    {
        $this->filePath = $filePath;
    }

    /**
     * @return string
     */
    public function getFilePath()
    {
        return $this->filePath;
    }

    /**
     * @param string $filePath
     *
     * @return $this
     */
    public function setFilePath($filePath)
    {
        $this->filePath = $filePath;

        return $this;
    }
}