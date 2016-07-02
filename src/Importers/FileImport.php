<?php
namespace michaeljamesparsons\DataImporter\Importers;

use michaeljamesparsons\DataImporter\Converters\ConverterInterface;
use michaeljamesparsons\DataImporter\Filters\FilterInterface;

/**
 * Class FileImport
 * @package michaeljamesparsons\DataImporter\Importers
 */
class FileImport extends AbstractImporter
{
	/** @var  int */
	protected $fileId;

	/** @var  string */
	protected $fileName;

	/** @var  array */
	protected $filters;

	/** @var  array */
	protected $converters;

	/**
	 * FileImport constructor.
	 *
	 * @param       $fileId
	 * @param       $fileName
	 * @param       $entity
	 * @param array $filters
	 * @param array $converters
	 */
	public function __construct($fileId, $fileName, $entity, $filters = [], $converters = [])
	{
		parent::__construct();
		$this->fileId     = $fileId;
		$this->fileName   = $fileName;
		$this->entity     = $entity;
		$this->filters    = $filters;
		$this->converters = $converters;
	}

	/**
	 * @return int
	 */
	public function getFileId()
	{
		return $this->fileId;
	}

	/**
	 * @param int $fileId
	 */
	public function setFileId($fileId)
	{
		$this->fileId = $fileId;
	}

	/**
	 * @return string
	 */
	public function getFileName()
	{
		return $this->fileName;
	}

	/**
	 * @param string $fileName
	 */
	public function setFileName($fileName)
	{
		$this->fileName = $fileName;
	}

	/**
	 * @return array
	 */
	public function getFilters()
	{
		return $this->filters;
	}

	/**
	 * @param FilterInterface $filter
	 */
	public function addFilter(FilterInterface $filter) {
		$this->filters = $filter;
	}

	/**
	 * @return array
	 */
	public function getConverters()
	{
		return $this->converters;
	}

	/**
	 * @param ConverterInterface $converter
	 */
	public function addConverter(ConverterInterface $converter) {
		$this->converters[] = $converter;
	}
}