<?php
namespace michaeljamesparsons\DataImporter\Workers;

use michaeljamesparsons\DataImporter\Helpers\RecordIndexCache;
use michaeljamesparsons\DataImporter\Readers\AbstractReader;
use michaeljamesparsons\DataImporter\Writers\DoctrineWriter;


/**
 * Class DatabaseWorker
 * @package sa\import\workers
 */
class DatabaseWorker extends ImportWorker
{
	/** @var  RecordIndexCache */
	protected $cache;

	public function __construct()
	{
		parent::__construct(null, null);
	}

	/**
	 * @param DoctrineWriter $writer
	 *
	 * @throws \Exception
	 */
	protected function processReaders(DoctrineWriter $writer) {
		/** @var AbstractReader $reader */
		foreach($this->readers as $entity => $readers) {
			foreach($readers as $reader) {
				$writer->setCurrentEntity($entity);
				$writer->flush();

				foreach($reader as $item) {
					$this->processItem($reader, $writer, $item);
				}
			}
		}
	}

	/**
	 * @param AbstractReader $reader
	 * @param string         $entity
	 *
	 * @return $this
	 */
	public function addReader(AbstractReader $reader, $entity) {
		if(!array_key_exists($entity, $this->readers)) {
			$this->readers[$entity] = [];
		}

		$this->readers[$entity][] = $reader;
		return $this;
	}
}