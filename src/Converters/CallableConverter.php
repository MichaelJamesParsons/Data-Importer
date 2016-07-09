<?php
namespace michaeljamesparsons\DataImporter\Converters;

/**
 * Class CallableConverter
 * @package michaeljamesparsons\DataImporter\Converters
 */
class CallableConverter implements ConverterInterface
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
            throw new \Exception("CallableConverter expects closure with 1 argument of type array.");
        }

        if($reflection->getReturnType() != 'array') {
            throw new \Exception("CallableConverter expects closure to return array.");
        }
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
        $callable = $this->callback;
        return $callable($item);
    }
}