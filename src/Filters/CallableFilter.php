<?php
namespace michaeljamesparsons\DataImporter\Filters;

/**
 * Class CallableFilter
 * @package michaeljamesparsons\DataImporter\Filters
 */
class CallableFilter implements FilterInterface
{
    /** @var  Callable */
    protected $callback;

    /**
     * CallableConverter constructor.
     *
     * @param callable $callback
     */
    public function __construct(Callable $callback)
    {
        $this->validate($callback);
        $this->callback = $callback;
    }

    /**
     * Validates that the callback method contains one parameter of type 'array', and also returns an array.
     *
     * @param callable $callback
     *
     * @throws \Exception
     */
    protected function validate(Callable $callback) {
        $reflection = new \ReflectionFunction($callback);
        $args = $reflection->getParameters();

        if($args != 1) {
            throw new \Exception("CallableFilter expects closure with 1 argument of type array.");
        }
    }

    /**
     * @param array $item
     *
     * @return bool
     */
    public function filter(array $item)
    {
        $callback = $this->callback;
        return $callback($item);
    }
}