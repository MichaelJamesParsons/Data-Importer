<?php
namespace michaeljamesparsons\DataImporter\Importers;

use michaeljamesparsons\DataImporter\Converters\IConverter;
use michaeljamesparsons\DataImporter\Filters\IFilterable;

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

	/** @var  string */
	protected $entity;

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
	 * @return string
	 */
	public function getEntity()
	{
		return $this->entity;
	}

	/**
	 * @param string $entity
	 */
	public function setEntity($entity)
	{
		$this->entity = $entity;
	}

	/**
	 * @return array
	 */
	public function getFilters()
	{
		return $this->filters;
	}

	/**
	 * @param IFilterable $filter
	 */
	public function addFilter(IFilterable $filter) {
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
	 * @param IConverter $converter
	 */
	public function addConverter(IConverter $converter) {
		$this->converters[] = $converter;
	}
}