<?php
namespace michaeljamesparsons\DataImporter\Readers;

/**
 * Class AbstractFileReader
 * @package michaeljamesparsons\DataImporter\Readers
 */
abstract class AbstractFileReader extends AbstractReader implements \SeekableIterator
{
	/** @var  string */
	protected $file_path;

	/** @var  \SplFileObject */
	protected $stream;

	public function __construct($file_path)
	{
		parent::__construct();

		$this->file_path = $file_path;
		$this->stream  = $this->loadFile($file_path);
	}

	/**
	 * Loads file into input stream as SplFileObject.
	 *
	 * @param string $file_path
	 *
	 * @return \SplFileObject
	 */
	protected function loadFile($file_path) {
		return new \SplFileObject($file_path);
	}

	/**
	 * @return string
	 */
	public function getFilePath()
	{
		return $this->file_path;
	}

	/**
	 * @param string $file_path
	 *
	 * @return $this
	 */
	public function setFilePath($file_path)
	{
		$this->file_path = $file_path;
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