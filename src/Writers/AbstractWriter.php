<?php
namespace michaeljamesparsons\DataImporter\Writers;

use michaeljamesparsons\DataImporter\Adapter\GenericEntity;

/**
 * Class AbstractWriter
 * @package michaeljamesparsons\DataImporter\Writers
 */
abstract class AbstractWriter
{
    /**
     * Import a single item.
     *
     * @param GenericEntity $item - The item to import.
     *
     * @throws \Exception
     */
    public function write(GenericEntity $item)
    {
        throw new \Exception("Writer not implemented.");
    }

    /**
     * Prepare writer before the import begins.
     *
     * Used to perform tasks and set conditions that must be completed in order for
     * the writer to properly write each item.
     */
    public function before()
    {
    }

    /**
     * Shut down writer after import.
     *
     * Used to unset the conditions that required for the writer to function.
     */
    public function after()
    {
    }
}