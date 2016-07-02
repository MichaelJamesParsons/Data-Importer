<?php
namespace michaeljamesparsons\DataImporter\Cache;

/**
 * Class ArrayCache
 * @package michaeljamesparsons\DataImporter\Cache
 */
class ArrayCache extends AbstractCache
{
	/** @var  array */
	protected $cache;

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