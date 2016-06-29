<?php
namespace michaeljamesparsons\DataImporter\Helpers;

/**
 * Class RecordIndexCache
 * @package michaeljamesparsons\DataImporter\Helpers
 */
class RecordIndexCache
{
	/** @var  array */
	protected $pendingRecords;

	/** @var  array */
	protected $keyMappings;

	public function __construct()
	{
		$this->pendingRecords = [];
		$this->keyMappings    = [];
	}

	/**
	 * @param $entity
	 * @param $key
	 * @param $object
	 */
	public function addPendingEntity($entity, $key, $object) {
		$this->pendingRecords[ $entity][ $key] = $object;
	}

	/**
	 * @param $entity
	 * @param $oldKey
	 * @param $newKey
	 */
	public function addKeyMapping($entity, $oldKey, $newKey) {
		if(!array_key_exists($entity, $this->keyMappings)) {
			$this->keyMappings[$entity] = [];
		}

		$this->keyMappings[$entity][$oldKey] = $newKey;
	}

	/**
	 * @param $key
	 * @param $entity
	 *
	 * @return mixed
	 */
	public function findMapping($key, $entity) {
		if(!empty($this->keyMappings[$entity][$key])) {
			return $this->keyMappings[$entity][$key];
		}

		return null;
	}

	/**
	 * @param array $mappers
	 */
	public function flush(array $mappers) {
		/** @var EntityMapper $mapper */
		foreach($mappers as $mapper) {
			$key = $mapper->getPrimaryKey();
			$entities = $this->pendingRecords[ $mapper->getEntity()];
			$getter = $mapper->getPropertyGetter($key);

			if(is_array($entities)) {
				foreach($entities as $oldKey => $entity) {
					$id = call_user_func_array([$entity, $getter], []);
					$this->addKeyMapping($mapper->getEntity(), $oldKey, $id);
				}
			}
		}
		$this->pendingRecords = [];
	}
}