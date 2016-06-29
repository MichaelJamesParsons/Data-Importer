<?php
namespace michaeljamesparsons\DataImporter\Helpers;

use ReflectionClass;
use michaeljamesparsons\DataImporter\Converters\IConverter;
use michaeljamesparsons\DataImporter\Filters\IFilterable;
use michaeljamesparsons\DataImporter\Importers\FileImport;

/**
 * Class SerializedFileImportsParser
 * @package michaeljamesparsons\DataImporter\Helpers
 *
 * @todo Move this to siteadmin module. Exclude from library!
 */
class SerializedFileImportsParser
{
	public static $registeredFilters = [
		'IndexRangeFilter' => 'sa\import\filters\IndexRangeFilter'
	];

	public static $registeredConverters = [
		'IndexConverter'            => '\sa\import\converters\IndexConverter',
		'IndexMergeConverter'       => '\sa\import\converters\IndexMergeConverter',
		'NestedArrayIndexConverter' => '\sa\import\converters\NestedArrayIndexConverter',
		'ValueToDateTimeConverter'  => '\sa\import\converters\ValueToDateTimeConverter'
	];

	/**
	 * Parses an array into a list of FileImport objects.
	 *
	 * @param array $importConfig
	 *
	 * @return array
	 * @throws \Exception
	 */
	public static function parse(array $importConfig) {
		$files = $importConfig['files'];
		$imports = [];

		/** @var array $file */
		foreach($files as $file) {
			$import = new FileImport($file['file_id'], $file['file_name'], $file['entity']);

			if(is_array($file['filters'])) {
				self::addFilters($import, $file['filters']);
			}

			if(is_array($file['converters'])) {
				self::addConverters($import, $file['converters']);
			}

			if(!empty($file['skip_record_on_error'])) {
				$import->setSkipRecordOnError($file['skip_record_on_error']);
			}

			$imports[] = $import;
		}

		return $imports;
	}

	/**
	 * Adds a list of filters to the import.
	 *
	 * @param FileImport $import
	 * @param array                         $filters
	 *
	 * @throws \Exception
	 */
	protected static function addFilters(FileImport $import, array $filters = []) {
		foreach($filters as $filter) {
			if(!array_key_exists($filter['type'], self::$registeredFilters)) {
				throw new \Exception("Filter of type \"{$filter['type']}\" does not exist.");
			}

			/** @var IFilterable $filterInstance */
			$filterInstance = self::getObjectInstance(self::$registeredFilters[$filter['type']], $filter['payload']);
			$import->addFilter($filterInstance);
		}
	}

	/**
	 * Adds a list of converters to the import.
	 *
	 * @param FileImport $import
	 * @param array                         $converters
	 *
	 * @throws \Exception
	 */
	protected static function addConverters(FileImport $import, array $converters = []) {
		foreach($converters as $converter) {
			if(!array_key_exists($converter['type'], self::$registeredConverters)) {
				throw new \Exception("Converter of type \"{$converter['type']}\" does not exist.");
			}

			/** @var IConverter $converterInstance */
			$converterInstance = self::getObjectInstance(
				self::$registeredConverters[$converter['type']],
				$converter['payload']
			);

			$import->addConverter($converterInstance);
		}
	}

	/**
	 * Dynamically creates an instance of an object and auto-fills the constructor.
	 *
	 * @param       $class      - The fully qualified name of the object.
	 * @param array $properties - A list of properties in key => value format.
	 *
	 * @return object
	 */
	protected static function getObjectInstance($class, array $properties = []) {
		$reflectionClass = new ReflectionClass($class);
		$constructorParams = $reflectionClass->getConstructor()->getParameters();
		$paramsValues = [];

		if(!empty($constructorParams)) {
			/** @var \ReflectionParameter $param */
			foreach($constructorParams as $param) {
				$paramsValues[] = (!empty($properties[$param->name])
			                   || (is_numeric($properties[$param->name]) && intval($properties[$param->name]) === 0))
					? $properties[$param->name]
					: null;
			}
		}

		return $reflectionClass->newInstanceArgs($paramsValues);
	}
}