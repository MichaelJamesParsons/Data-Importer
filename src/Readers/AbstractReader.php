<?php
namespace michaeljamesparsons\DataImporter\Readers;

use michaeljamesparsons\DataImporter\Adapter\AbstractAdapter;
use michaeljamesparsons\DataImporter\Converters\ConverterInterface;
use michaeljamesparsons\DataImporter\Filters\FilterInterface;

/**
 * Class AbstractReader
 * @package michaeljamesparsons\DataImporter\Readers
 */
abstract class AbstractReader implements \Iterator
{
    /** @var  array */
    protected $filters;

    /** @var  array */
    protected $converters;

    /** @var  AbstractAdapter */
    protected $adapter;

    public function __construct()
    {
        $this->filters    = [];
        $this->converters = [];
    }

    /**
     * Adds a filter to the reader's filter queue.
     *
     * @param FilterInterface $filter
     *
     * @return $this
     */
    public function addFilter(FilterInterface $filter)
    {
        $this->filters[] = $filter;

        return $this;
    }

    /**
     * Determines if an item meets the requirements to be filtered.
     *
     * @param array $item
     *
     * @return bool
     */
    public function filter(array $item)
    {
        /** @var FilterInterface $filter */
        foreach ($this->filters as $filter) {
            if (!$filter->filter($item)) {
                return false;
            }
        }

        return true;
    }

    /**
     * @param ConverterInterface $converter
     *
     * @return $this
     */
    public function addConverter(ConverterInterface $converter)
    {
        $this->converters[] = $converter;

        return $this;
    }

    /**
     * @param $item
     *
     * @return array
     */
    public function convert($item)
    {
        /** @var ConverterInterface $converter */
        foreach ($this->converters as $converter) {
            $item = $converter->convert($item);
        }

        return $item;
    }

    /**
     * @param AbstractAdapter $adapter
     *
     * @return $this
     */
    public function setAdapter($adapter)
    {
        $this->adapter = $adapter;

        return $this;
    }
}