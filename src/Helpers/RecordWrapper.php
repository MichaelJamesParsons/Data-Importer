<?php
namespace michaeljamesparsons\DataImporter\Helpers;

/**
 * Class RecordWrapper
 * @package michaeljamesparsons\DataImporter\Helpers
 */
class RecordWrapper
{
    /** @var  string */
    protected $namespace;

    /** @var  string */
    protected $importedKey;

    /** @var string */
    protected $storedKey;

    /** @var array */
    protected $item;

    /** @var object */
    protected $entity;

    /**
     * RecordWrapper constructor.
     *
     * @param       $namespace
     * @param array $item
     * @param       $importedKey
     * @param null  $storedKey
     * @param null  $object
     */
    public function __construct($namespace, array $item, $importedKey, $storedKey = null, $object = null)
    {
        $this->item        = $item;
        $this->importedKey = $importedKey;
        $this->storedKey   = $storedKey;
        $this->namespace   = $namespace;
        $this->entity      = $object;
    }

    /**
     * @return string
     */
    public function getNamespace()
    {
        return $this->namespace;
    }

    /**
     * @param string $namespace
     */
    public function setNamespace($namespace)
    {
        $this->namespace = $namespace;
    }

    /**
     * @return string
     */
    public function getImportedKey()
    {
        return $this->importedKey;
    }

    /**
     * @param string $importedKey
     */
    public function setImportedKey($importedKey)
    {
        $this->importedKey = $importedKey;
    }

    /**
     * @return string
     */
    public function getStoredKey()
    {
        return $this->storedKey;
    }

    /**
     * @param string $storedKey
     */
    public function setStoredKey($storedKey)
    {
        $this->storedKey = $storedKey;
    }

    /**
     * @return array
     */
    public function getItem()
    {
        return $this->item;
    }

    /**
     * @param array $item
     */
    public function setItem($item)
    {
        $this->item = $item;
    }

    /**
     * @return object
     */
    public function getEntity()
    {
        return $this->entity;
    }

    /**
     * @param object $entity
     */
    public function setEntity($entity)
    {
        $this->entity = $entity;
    }
}