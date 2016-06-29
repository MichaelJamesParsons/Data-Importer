<?php
namespace michaeljamesparsons\DataImporter\Filters;

/**
 * Class IndexRangeFilter
 * @package sa\import\filters
 *
 * Filters out items that are outside of a given index range.
 *
 * This filter can be used to start and stop an import at specific at any points.
 */
class IndexRangeFilter implements IFilterable
{
	/** @var  int */
	protected $start;

	/** @var  int */
	protected $end;

	/** @var  int */
	protected $current;

	/** @var  bool */
	protected $limitReached;

	/**
	 * IndexRangeFilter constructor.
	 *
	 * @param int  $start
	 * @param int $end
	 */
	public function __construct($start = 0, $end = null)
	{
		$this->start    = $start;
		$this->end      = $end;
		$this->current  = 0;
		$this->limitReached = false;
	}

	/**
	 * @inheritdoc
	 */
	public function filter(array $item)
	{
		$this->current++;

		if($this->limitReached
		   || $this->current - 1 < $this->start
		   || ($this->end != null && $this->current - 1 > $this->end)) {
			return false;
		}

		if($this->current - 1 === $this->end) {
			$this->limitReached = true;
		}

		return true;
	}
}