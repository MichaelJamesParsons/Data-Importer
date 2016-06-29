<?php
namespace michaeljamesparsons\DataImporter\Writers;

/**
 * Class AbstractFileWriter
 * @package michaeljamesparsons\DataImporter\Writers
 */
abstract class AbstractFileWriter extends AbstractWriter
{
	/** @var  string */
	protected $file_path;

	/**
	 * AbstractFileWriter constructor.
	 *
	 * @param string $file_path
	 */
	public function __construct($file_path)
	{
		$this->file_path = $file_path;
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
}