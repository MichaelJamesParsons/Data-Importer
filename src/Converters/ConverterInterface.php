<?php
namespace michaeljamesparsons\DataImporter\Converters;

/**
 * Interface ConverterInterface
 * @package michaeljamesparsons\DataImporter\Converters
 */
interface ConverterInterface
{
    /**
     * Converts an item's indexes and values before being imported.
     *
     * @param array $item
     *
     * @return array
     */
    public function convert(array $item);
}