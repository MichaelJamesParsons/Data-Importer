<?php
namespace michaeljamesparsons\DataImporter\Workers;

use Exception;
use michaeljamesparsons\DataImporter\Readers\AbstractReader;
use michaeljamesparsons\DataImporter\Reporters\Report;
use michaeljamesparsons\DataImporter\Writers\AbstractWriter;


/**
 * Class DefaultWorkflow
 * @package sa\import
 */
class DefaultWorkflow extends AbstractWorkflow
{
	/**
	 * @return Report
	 * @throws Exception
	 */
	public function process() {
        $this->reporter->start();

		/** @var AbstractWriter $writer */
		foreach($this->writers as $writer) {
			$writer->before();
			$this->processReaders($writer);
			$writer->after();
		}

        $this->reporter->stop();
        return $this->reporter;
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
					$this->reporter->incrementImportCount();
				} catch(\Exception $e) {
                    $this->reporter->incrementErrorCount();
					if($this->skipRecordOnError) {
						continue;
					}

					throw $e;
				}
			}
		}
	}
}