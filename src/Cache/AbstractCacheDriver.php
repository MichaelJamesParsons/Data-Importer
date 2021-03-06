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
     * @param string                $name  - The name of the entity or table in which the record is being stored.
     *
     * @return void
     */
    public abstract function add($name, $key, $value);

    /**
     * @param string                $key   - A unique key for a given key => value pair.
     * @param string|int|float|bool $value - A value to be stored in the cache.
     * @param string                $name  - The name of the entity or table in which the record is being stored.
     *
     * @return void
     */
    public abstract function update($name, $key, $value);

    /**
     * Removes a key => value pair from the cache.
     *
     * @param string $key
     * @param string $name  - The name of the entity or table in which the record is being stored.
     *
     * @return void
     */
    public abstract function remove($name, $key);

    /**
     * Finds a value in the cache from the given key.
     *
     * @param string $key - A unique key for a key => value pair.
     * @param string $name  - The name of the entity or table in which the record is being stored.
     *
     * @return string|int|float|bool
     */
    public abstract function find($name, $key);
}