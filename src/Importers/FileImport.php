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
	protected $file_id;

	/** @var  string */
	protected $file_name;

	/** @var  string */
	protected $entity;

	/** @var  array */
	protected $filters;

	/** @var  array */
	protected $converters;

	/**
	 * FileImport constructor.
	 *
	 * @param       $file_id
	 * @param       $file_name
	 * @param       $entity
	 * @param array $filters
	 * @param array $converters
	 */
	public function __construct($file_id, $file_name, $entity, $filters = [], $converters = [])
	{
		parent::__construct();
		$this->file_id    = $file_id;
		$this->file_name  = $file_name;
		$this->entity     = $entity;
		$this->filters    = $filters;
		$this->converters = $converters;
	}

	/**
	 * @return int
	 */
	public function getFileId()
	{
		return $this->file_id;
	}

	/**
	 * @param int $file_id
	 */
	public function setFileId($file_id)
	{
		$this->file_id = $file_id;
	}

	/**
	 * @return string
	 */
	public function getFileName()
	{
		return $this->file_name;
	}

	/**
	 * @param string $file_name
	 */
	public function setFileName($file_name)
	{
		$this->file_name = $file_name;
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