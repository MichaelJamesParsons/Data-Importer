<?php
namespace michaeljamesparsons\DataImporter\Readers;

/**
 * Class CsvReader
 * @package michaeljamesparsons\DataImporter\Readers
 */
class CsvReader extends AbstractFileReader
{
    /**
     * CsvReader constructor.
     *
     * @param string $filePath - The absolute path to the file.
     * @param string $delimiter
     * @param string $enclosure
     * @param string $escape
     */
    public function __construct($filePath, $delimiter = ',', $enclosure = '"', $escape = '\\')
    {
        parent::__construct($filePath);
        ini_set('auto_detect_line_endings', true);

        $this->stream->setFlags(
            \SplFileObject::READ_CSV |
            \SplFileObject::SKIP_EMPTY |
            \SplFileObject::READ_AHEAD |
            \SplFileObject::DROP_NEW_LINE
        );

        $this->stream->setCsvControl($delimiter, $enclosure, $escape);
    }
}