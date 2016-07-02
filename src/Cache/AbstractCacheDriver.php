<?php
namespace michaeljamesparsons\DataImporter\Cache;

/**
 * Class AbstractCacheDriver
 * @package michaeljamesparsons\DataImporter\Cache
 */
abstract class AbstractCacheDriver
{
    /**
     * @param string                $key   - A unique key for a given key => value pair.
     * @param string|int|float|bool $value - A value to be stored in the cache.
     *
     * @return void
     */
    public abstract function add($key, $value);

    /**
     * Removes a key => value pair from the cache.
     *
     * @param string $key
     *
     * @return void
     */
    public abstract function remove($key);

    /**
     * Finds a value in the cache from the given key.
     *
     * @param string $key - A unique key for a key => value pair.
     *
     * @return string|int|float|bool
     */
    public abstract function find($key);

    /**
     * Generate a hash used to look up values in the cache.
     *
     * @param string $key - A unique key for a given key => value pair.
     *
     * @return string
     */
    protected function hashKey($key)
    {
        return md5($key);
    }
}