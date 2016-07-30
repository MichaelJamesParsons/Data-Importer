<?php
namespace michaeljamesparsons\DataImporter\Writers;

/**
 * Class RelationalItem
 * @package michaeljamesparsons\DataImporter\Writers
 */
class RelationalItem
{
    /** @var  int */
    protected $importedId;

    /** @var int */
    protected $originalId;

    /** @var  array */
    protected $values;

    public function __construct($originalId, array $values = [], $importedId)
    {
        $this->originalId = $originalId;
        $this->values     = $values;
        $this->importedId = $importedId;
    }

    /**
     * @return int
     */
    public function getImportedId()
    {
        return $this->importedId;
    }

    /**
     * @param int $importedId
     *
     * @return $this
     */
    public function setImportedId($importedId)
    {
        $this->importedId = $importedId;

        return $this;
    }

    /**
     * @return int
     */
    public function getOriginalId()
    {
        return $this->originalId;
    }

    /**
     * @param int $originalId
     *
     * @return $this
     */
    public function setOriginalId($originalId)
    {
        $this->originalId = $originalId;

        return $this;
    }

    /**
     * @return array
     */
    public function getValues()
    {
        return $this->values;
    }

    /**
     * @param array $values
     *
     * @return $this
     */
    public function setValues($values)
    {
        $this->values = $values;

        return $this;
    }
}