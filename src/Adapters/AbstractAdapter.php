<?php
namespace michaeljamesparsons\DataImporter\Adapter;

/**
 * Class AbstractAdapter
 * @package michaeljamesparsons\DataImporter\Adapter
 */
abstract class AbstractAdapter
{
    public abstract function adapt(array $data);
}