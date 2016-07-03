<?php
namespace michaeljamesparsons\DataImporter\Readers;

/**
 * Class AbstractFileReader
 * @package michaeljamesparsons\DataImporter\Readers
 */
abstract class AbstractFileReader extends AbstractReader implements \SeekableIterator
{
    /** @var  string */
    protected $filePath;

    /** @var  \SplFileObject */
    protected $stream;

    /**
     * AbstractFileReader constructor.
     *
     * @param $filePath - The absolute path to the file.
     */
    public function __construct($filePath)
    {
        parent::__construct();

        $this->filePath = $filePath;
        $this->stream   = $this->loadFile($filePath);
    }

    /**
     * Loads file into input stream as SplFileObject.
     *
     * @param string $filePath - The absolute path to the file.
     *
     * @return \SplFileObject
     */
    protected function loadFile($filePath)
    {
        return new \SplFileObject($filePath);
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

    /**
     * @inheritdoc
     */
    public function current()
    {
        return $this->stream->current();
    }

    /**
     * @inheritdoc
     */
    public function next()
    {
        $this->stream->next();
    }

    /**
     * @inheritdoc
     */
    public function key()
    {
        return $this->stream->key();
    }

    /**
     * @inheritdoc
     */
    public function valid()
    {
        return $this->stream->valid();
    }

    /**
     * @inheritdoc
     */
    public function rewind()
    {
        $this->stream->rewind();
    }

    /**
     * @inheritdoc
     */
    public function seek($position)
    {
        $this->stream->seek($position);
    }
}