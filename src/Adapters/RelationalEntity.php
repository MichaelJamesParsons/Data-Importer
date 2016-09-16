<?php
namespace michaeljamesparsons\DataImporter\Adapter;

/**
 * Class RelationalEntity
 * @package michaeljamesparsons\DataImporter\Adapter
 */
class RelationalEntity extends GenericEntity
{
    /** @var  string */
    private $name;

    /** @var  boolean */
    private $isWritten;

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
