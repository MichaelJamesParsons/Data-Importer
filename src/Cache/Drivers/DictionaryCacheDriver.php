<?php
namespace michaeljamesparsons\DataImporter\Cache\Drivers;

use michaeljamesparsons\DataImporter\Cache\AbstractCacheDriver;

/**
 * Class Driver
 * @package michaeljamesparsons\DataImporter\Cache\Drivers
 */
class DictionaryCacheDriver extends AbstractCacheDriver
{
    /** @var  array */
    protected $cache;

    /**
     * Driver constructor.
     */
    public function __construct()
    {
        $this->cache = [];
    }

    /**
     * @inheritdoc
     */
    public function add($key, $value)
    {
        $this->cache[$this->hashKey($key)] = $value;
    }

    /**
     * @inheritdoc
     */
    public function remove($key)
    {
        unset($this->cache[$this->hashKey($key)]);
    }

    /**
     * @inheritdoc
     */
    public function find($key)
    {
        return $this->cache[$this->hashKey($key)];
    }
}