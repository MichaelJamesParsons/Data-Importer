<?php
namespace michaeljamesparsons\DataImporter\Converters;

/**
 * Class IndexMergeConverterInterface
 * @package michaeljamesparsons\DataImporter\Converters
 *
 * Merges the values of 1-n indexes into a single new index.
 */
class IndexMergeConverter implements ConverterInterface
{
    /** @var  array */
    protected $indexes;

    /** @var  string */
    protected $rename;

    /** @var  string */
    protected $delimiter;

    public function __construct(array $indexes, $rename, $delimiter = ' ')
    {
        $this->indexes   = $indexes;
        $this->rename    = $rename;
        $this->delimiter = $delimiter;
    }

    /**
     * Converts an item's indexes and values before being imported.
     *
     * @param array $item
     *
     * @return array
     */
    public function convert(array $item)
    {
        $values = [];
        foreach ($this->indexes as $index) {
            if (!empty($item[$index])) {
                $values[] = $item[$index];
            }
        }

        $item[$this->rename] = implode($this->delimiter, $values);

        return $item;
    }
}