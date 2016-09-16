<?php
namespace michaeljamesparsons\DataImporter\Adapter;

/**
 * Class GenericEntity
 * @package michaeljamesparsons\DataImporter\Adapter
 */
class GenericEntity
{
    /** @var  array */
    private $record;

    /**
     * @return array
     */
    public function getRecord()
    {
        return $this->record;
    }

    /**
     * @param array $record
     *
     * @return $this
     */
    public function setRecord($record)
    {
        $this->record = $record;

        return $this;
    }
}