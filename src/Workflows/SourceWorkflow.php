<?php
namespace michaeljamesparsons\DataImporter\Workflows;

use michaeljamesparsons\DataImporter\Readers\AbstractReader;
use michaeljamesparsons\DataImporter\Writers\AbstractWriter;

/**
 * Class SourceWorkflow
 * @package michaeljamesparsons\DataImporter\Workflows
 */
class SourceWorkflow extends DefaultWorkflow
{
    /**
     * @inheritdoc
     */
    protected function processItem(AbstractReader $reader, AbstractWriter $writer, array $item) {
        reset($item);
        $firstKey = key($item);

        if(count($item) > 1 || !is_array($item[$firstKey])) {
            throw new \Exception("Unexpected structure: SourceWorkflow expects all items to contain 1 index 
                                  where the key is the type of entity and the value is an array of its properties.");
        }

        parent::processItem($reader, $writer, $item);
    }
}