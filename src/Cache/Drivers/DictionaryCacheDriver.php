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
    public function add($name, $key, $value)
    {
        if(!array_key_exists($name, $this->cache)) {
            $this->cache[$name] = [];
        }

        $this->cache[$name][$key] = $value;
    }

    /**
     * @inheritdoc
     */
    public function update($name, $key, $value)
    {
        $this->cache[$name][$key] = $value;
    }

    /**
     * @inheritdoc
     */
    public function remove($name, $key)
    {
        unset($this->cache[$name][$key]);
    }

    /**
     * @inheritdoc
     */
    public function find($name, $key)
    {
        return $this->cache[$name][$key];
    }
}