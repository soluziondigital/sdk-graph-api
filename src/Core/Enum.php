<?php
namespace Microsoft\Graph\Core;

use Microsoft\Graph\Exception\GraphException;

abstract class Enum
{
    private static $constants = [];
    private $_value;

    public function __construct($value)
    {
        if (!self::has($value)) {
            throw new GraphException("Invalid enum value $value");
        }
        $this->_value = $value;
    }

    public function has($value)
    {
        return in_array($value, self::toArray(), true);
    }

    public function is($value)
    {
        return $this->_value === $value;
    }

    public function toArray()
    {
        $class = get_called_class();

        if (!(array_key_exists($class, self::$constants)))
        {
            $reflectionObj = new \ReflectionClass($class);
            self::$constants[$class] = $reflectionObj->getConstants();
        }
        return self::$constants[$class];
    }

    public function value()
    {
        return $this->_value;
    }
}