<?php
namespace michaeljamesparsons\DataImporter\Context;

/**
 * Class Entity
 * @package michaeljamesparsons\DataImporter\Context
 */
class Entity
{
    protected $name;
    protected $data;
    protected $isWritten;

    public function __construct($name, array $data)
    {
        $this->name        = $name;
        $this->data        = $data;
        $this->isWritten   = false;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return $this
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param array $data
     *
     * @return $this
     */
    public function setData($data)
    {
        $this->data = $data;

        return $this;
    }

    /**
     * @return boolean
     */
    public function isIsWritten()
    {
        return $this->isWritten;
    }

    /**
     * @param boolean $isWritten
     *
     * @return $this
     */
    public function setIsWritten($isWritten)
    {
        $this->isWritten = $isWritten;

        return $this;
    }
}