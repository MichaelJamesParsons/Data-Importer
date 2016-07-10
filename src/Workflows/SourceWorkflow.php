<?php
namespace michaeljamesparsons\DataImporter\Workflows;

use michaeljamesparsons\DataImporter\Readers\AbstractReader;
use michaeljamesparsons\DataImporter\Writers\AbstractSourceWriter;

/**
 * Class SourceWorkflow
 * @package michaeljamesparsons\DataImporter\Workflows
 */
class SourceWorkflow extends DefaultWorkflow
{
    /**
     * @param AbstractReader $reader
     * @param                $entity - The name (or type) of item being processed.
     *
     * @return $this
     */
    public function addReader(AbstractReader $reader, $entity)
    {
        $this->readers[$entity] = $reader;

        return $this;
    }

    protected function processReaders(AbstractSourceWriter $writer)
    {
        /** @var AbstractReader $reader */
        foreach ($this->readers as $entity => $reader) {
            foreach ($reader as $item) {
                $this->processItem($reader, $writer, $item, $entity);
            }
        }
    }

    /**
     * @inheritdoc
     */
    protected function processItem(AbstractReader $reader, AbstractSourceWriter $writer, array $item, $entity)
    {
        try {
            if (!$reader->filter($item)) {
                return;
            }

            $writer->write($reader->convert($item), $entity);
            $this->reporter->incrementImportCount();
        } catch (\Exception $e) {
            $this->reporter->incrementErrorCount();
            if ($this->skipRecordOnError) {
                return;
            }

            throw $e;
        }
    }
}