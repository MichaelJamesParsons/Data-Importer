<?php
namespace michaeljamesparsons\DataImporter\Workers;

use Exception;
use michaeljamesparsons\DataImporter\Readers\AbstractReader;
use michaeljamesparsons\DataImporter\Reporters\Report;
use michaeljamesparsons\DataImporter\Writers\AbstractWriter;


/**
 * Class ImportWorker
 * @package sa\import
 */
class ImportWorker extends AbstractImportWorker
{
	/** @var  array */
	protected $readers;

	/** @var  array */
	protected $writers;

	/**
	 * ImportWorker constructor.
	 *
	 * @param AbstractReader $reader
	 * @param AbstractWriter $writer
	 */
	public function __construct(AbstractReader $reader, AbstractWriter $writer)
	{
		parent::__construct();
		$this->readers    = (!is_null($reader)) ? [$reader] : [];
		$this->writers    = (!is_null($writer)) ? [$writer] : [];
		$this->skipRecordOnError = true;
	}

	/**
	 * @return Report
	 * @throws Exception
	 */
	public function process() {
		$this->initialize();

		/** @var AbstractWriter $writer */
		foreach($this->writers as $writer) {
			$writer->before();
			$this->processReaders($writer);
			$writer->after();
		}

		return $this->report();
	}

	/**
	 * @param AbstractWriter $writer
	 *
	 * @throws \Exception
	 */
	protected function processReaders(AbstractWriter $writer) {
		/** @var AbstractReader $reader */
		foreach($this->readers as $reader) {
			foreach($reader as $item) {
				try {
					if(!$reader->filter($item)) {
						continue;
					}

					$writer->write($reader->convert($item));
					$this->importCount++;
				} catch(\Exception $e) {
					$this->errorCount++;
					if($this->skipRecordOnError) {
						continue;
					}

					throw $e;
				}
			}
		}
	}

	/**
	 * @param AbstractReader $reader
	 * @param AbstractWriter $writer
	 * @param array                             $item
	 *
	 * @return null
	 * @throws \Exception
	 */
	protected function processItem(AbstractReader $reader, AbstractWriter $writer, array $item) {
		try {
			if(!$reader->filter($item)) {
				return null;
			}

			$writer->write($reader->convert($item));
			$this->importCount++;
		} catch(\Exception $e) {
			$this->errorCount++;
			if($this->skipRecordOnError) {
				return null;
			}

			throw $e;
		}
	}
}