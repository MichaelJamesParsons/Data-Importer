<?php
namespace michaeljamesparsons\DataImporter\Writers;

use michaeljamesparsons\DataImporter\Cache\AbstractCacheDriver;
use michaeljamesparsons\DataImporter\Context\AbstractDatabaseContext;

/**
 * Class AbstractDatabaseWriter
 * @package michaeljamesparsons\DataImporter\Writers
 */
abstract class AbstractDatabaseWriter extends AbstractSourceWriter
{
    /**
     * The number of items imported.
     *
     * @var int
     */
    protected $count;

    /**
     * The number of records to save at one time.
     *
     * @var int
     */
    protected $bundleSize;

    /**
     * If true, the database tables will be truncated before executing the import.
     * 
     * @var  bool
     */
    protected $truncate;

    /**
     * AbstractDatabaseWriter constructor.
     *
     * @param AbstractDatabaseContext $context
     * @param AbstractCacheDriver     $cache
     * @param int                     $bundleSize
     */
    public function __construct(AbstractDatabaseContext $context, AbstractCacheDriver $cache = null, $bundleSize = 300)
    {
        parent::__construct($context, $cache);

        //This is here for IDE code completion purposes.
        $this->context = $context;
        $this->bundleSize  = $bundleSize;
        $this->count       = 0;
    }

    /**
     * @return boolean
     */
    public function truncate()
    {
        return $this->truncate;
    }

    /**
     * @param boolean $truncate
     */
    public function setTruncate($truncate)
    {
        $this->truncate = $truncate;
    }

    /**
     * @inheritdoc
     */
    public function before()
    {
        if ($this->truncate) {
            $this->context->truncateTable();
        }
    }

    /**
     * @inheritdoc
     */
    public function after()
    {
        $this->context->flush();
    }

    /**
     * Fetch an existing record or create a new one if it does not already exist.
     *
     * @param $item
     *
     * @return object - The record or entity.
     */
    protected abstract function findOrCreateIfNotExists($item);
}