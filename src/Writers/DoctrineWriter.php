<?php
namespace michaeljamesparsons\DataImporter\Writers;

use Doctrine\ORM\Configuration;
use Doctrine\ORM\EntityManager;
use Doctrine\DBAL\Logging\SQLLogger;
use Doctrine\ORM\EntityRepository;
use michaeljamesparsons\DataImporter\Helpers\EntityMapper;
use michaeljamesparsons\DataImporter\Helpers\EntityRelationship;
use michaeljamesparsons\DataImporter\Helpers\RecordWrapper;

/**
 * Class DoctrineWriter
 * @package sa\import\writers
 *
 * @todo Use entity manager to fetch entity info instead of using mappers.
 * @todo Move to another library.
 * @todo Move shared logic to parent abstract classes.
 */
class DoctrineWriter extends AbstractOrmWriter
{
	/** @var  array */
	protected $mappers;

	/** @var  array */
	protected $repositories;

	/** @var Configuration  */
	protected $config;

	/** @var  SQLLogger */
	protected $logger;

	/** @var  string */
	protected $currentEntity;

	/** @var  EntityManager */
	protected $context;

	/** @var  int */
	protected $depth;

	/**
	 * DoctrineWriter constructor.
	 *
	 * @param \Doctrine\ORM\EntityManager $entityManager
	 * @param int                         $batchSize
	 */
	public function __construct(EntityManager $entityManager, $batchSize = 100) {
		/** @var EntityManager $entityManager */
		parent::__construct($entityManager, $batchSize);

		$this->config = $entityManager->getConfiguration();
		$this->depth = 0;
		$this->mappers = [];
	}

	/**
	 * Import a single item.
	 *
	 * @todo This is abstract enough to move to the parent class.
	 *
	 * @param array $item - The item to import.
	 *
	 * @return mixed
	 */
	public function write(array $item)
	{
		$this->count++;
		$wrapper = new RecordWrapper($this->currentEntity, $item, $item[ $this->getMapper()->getPrimaryKey()]);

		$this->findOrCreateIfNotExists($wrapper);
		$this->mapProperties($wrapper, $this->getMapper());

		if(!$wrapper->getStoredKey()) {
			$this->persist($wrapper->getEntity());
		}

		if($this->enableCache && !empty($wrapper->getImportedKey())) {
			if($wrapper->getStoredKey() != null) {
				$this->cache->addKeyMapping($this->currentEntity, $wrapper->getImportedKey(), $wrapper->getStoredKey());
			} else {
				$this->cache->addPendingEntity(
					$this->currentEntity,
					$item[$this->getMapper()->getPrimaryKey()],
					$wrapper->getEntity()
				);
			}
		}

		if($this->count != 0 && ($this->count % $this->bundleSize) == 0 && $this->depth == 0) {
			$this->flush();
		}

		return $wrapper->getEntity();
	}

	/**
	 * @param RecordWrapper        $wrapper
	 * @param EntityMapper $mapper
	 *
	 * @return object
	 */
	public function mapProperties(RecordWrapper $wrapper, EntityMapper $mapper) {
		foreach($mapper->getProperties() as $property) {
			$item = $wrapper->getItem();

			if(array_key_exists($property, $wrapper->getItem())) {
				if($property == $mapper->getPrimaryKey() && !$mapper->hasImportablePrimaryKey()) {
					continue;
				}

				$relationship = $mapper->findRelationship($property);
				$value = (!$relationship) ? $item[$property] : $this->processRelationship($wrapper, $relationship);

				if(!empty($value)) {
					call_user_func_array([
						$wrapper->getEntity(),
						$mapper->getPropertySetter($property)
					], [$value]);
				}
			}
		}
	}

	/**
	 * @param RecordWrapper      $wrapper
	 * @param EntityRelationship $relationship
	 *
	 * @return object
	 * @throws \Exception
	 */
	protected function processRelationship(RecordWrapper $wrapper, EntityRelationship $relationship) {
		$item  = $wrapper->getItem();

		$value = $item[$relationship->getProperty()];
		$currentEntity = $this->currentEntity;

		$this->setCurrentEntity($relationship->getEntity());
		$this->depth++;

		$relatedEntity = null;
		if(is_array($value)) {
			$relatedEntity = $this->write($value);
		} elseif(!empty($value)) {
			$primaryKey = $this->getMapper()->getPrimaryKey();

			if(!empty($primaryKey)) {
				$relatedEntity = $this->write([
					$primaryKey => $value
				]);
			}
		}

		$this->depth--;
		$this->setCurrentEntity($currentEntity);

		$this->context->persist($relatedEntity);
		return $relatedEntity;
	}

	/**
	 * @return EntityMapper
	 */
	protected function getMapper() {
		return $this->mappers[$this->currentEntity];
	}

	/**
	 * @param $entity
	 *
	 * @return mixed
	 */
	protected function resolveEntityObject($entity) {
		return new $entity();
	}

	/**
	 * @inheritdoc
	 *
	 * @todo - Clean up
	 */
	protected function findOrCreateIfNotExists(RecordWrapper $wrapper)
	{
		/** @var array $item */
		$item = $wrapper->getItem();

		/** @var EntityMapper $mapper */
		$mapper = $this->getMapper();

		/** @var EntityRepository $repository */
		$repository = $this->repositories[$this->currentEntity];

		/**
		 * Entity is already stored.
		 */
		if(!empty($wrapper->getStoredKey())) {
			$entity = $this->context->getReference($this->currentEntity, $wrapper->getStoredKey());

		/**
		 * Find entity by pre-defined fields.
		 *
		 * @todo - potential bug. Check for mapping before using this. Don't allow look-ups by primary key.
		 */
		} else if(!empty($mapper->getLookupFields())) {
			$search = [];
			foreach($mapper->getLookupFields() as $field) {
				$search[ $field ] = $item[ $field ];
			}

			$entity = $repository->findOneBy($search);

			/**
			 * Check if entity has already been cached.
			 */
		}

		if(empty($entity)) {
			$newKey = $this->cache->findMapping($wrapper->getImportedKey(), $this->currentEntity);

			if(!is_null($newKey)) {
				$entity = $this->context->getReference($this->currentEntity, $newKey);
			}
		}

		if(empty($entity)) {
			$entity = $this->resolveEntityObject($this->currentEntity);
		}

		$wrapper->setStoredKey(call_user_func([$entity, $mapper->getPrimaryKeyGetter()]));
		$wrapper->setEntity($entity);
	}

	/**
	 * @inheritdoc
	 */
	protected function persist($entity)
	{
		$this->context->persist($entity);
	}

	/**
	 * @inheritdoc
	 */
	public function flush() {
		$this->context->flush();
		$this->cache->flush($this->mappers);
		$this->context->clear();
		$this->count = 0;
	}

	/**
	 * @inheritdoc
	 */
	protected function disableDatabaseLogging()
	{
		$this->logger = $this->config->getSQLLogger();
		$this->config->setSQLLogger(null);
	}

	/**
	 * @inheritdoc
	 */
	protected function enableDatabaseLogging()
	{
		$this->config->setSQLLogger($this->logger);
	}

	/**
	 * @inheritdoc
	 */
	protected function truncateTable()
	{
		// TODO: Implement truncateTables() method.
	}

	/**
	 * @param EntityMapper $mapper
	 *
	 * @return $this
	 */
	public function addMapper(EntityMapper $mapper) {
		$this->mappers[$mapper->getEntity()] = $mapper;
		return $this;
	}

	/**
	 * @param $entity
	 *
	 * @throws \Exception
	 */
	public function setCurrentEntity($entity) {
		if(!array_key_exists($entity, $this->mappers)) {
			throw new \Exception("Mapper for entity of type \"{$entity}\" is not defined within writer.");
		}

		$this->currentEntity = $entity;
	}

	/**
	 * @inheritdoc
	 */
	public function before()
	{
		parent::before();
		$this->initializeRepositories();
		$this->initializeCache();
	}

	/**
	 * Determines if caching is necessary.
	 */
	protected function initializeCache() {
		if(empty($this->mappers)) {
			throw new ValidateException("Entity mappers not defined.");
		}

		/** @var EntityMapper $mapper */
		foreach($this->mappers as $mapper) {
			/** @var EntityRelationship $relationship */
			foreach($mapper->getRelationships() as $relationship) {
				if(array_key_exists($relationship->getEntity(), $this->mappers)) {
					$this->enableCache = true;
					break 2;
				}
			}
		}
	}

	/**
	 * Caches the repository for each entity.
	 *
	 * @throws \Exception
	 */
	protected function initializeRepositories() {
		/** @var EntityMapper $mapper */
		foreach($this->mappers as $mapper) {
			$this->repositories[$mapper->getEntity()] = $this->findRepository($mapper->getEntity());
		}
	}

	/**
	 * Find the corresponding repository for the given entity.
	 *
	 * @param $entity
	 *
	 * @return \Doctrine\ORM\EntityRepository
	 * @throws \Exception
	 */
	protected function findRepository($entity) {
		$repository = $this->context->getRepository($entity);

		if(!$repository) {
			throw new \Exception("Repository not found for entity {$entity}.");
		}

		return $repository;
	}
}