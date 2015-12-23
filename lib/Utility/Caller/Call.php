<?php

/*
 * This file is part of the Wonka Library.
 *
 * (c) Scribe Inc.     <oss@src.run>
 * (c) Rob Frawley 2nd <rmf@src.run>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\Wonka\Utility\Caller;

use Scribe\Wonka\Exception\InvalidArgumentException;
use Scribe\Wonka\Exception\BadFunctionCallException;
use Scribe\Wonka\Utility\StaticClass\StaticClassTrait;

/**
 * Class Call.
 *
 * Static function collection to call either global functions or object methods
 * indirectly with checks that the requested function/method exists.
 */
class Call implements CallInterface
{
    /*
     * disallow instantiation
     */
    use StaticClassTrait;

    /**
     * Call a global function or class method (if exists) or callable with specified arguments.
     *
     * @param string|array|\Closure $callable  A global function name or class method (if exists) or callable
     * @param mixed,...             $arguments Arguments to pass to the global function
     *
     * @return mixed
     */
    public static function generic($callable, ...$arguments)
    {
        if (true === is_array($callable)) {
            return self::handle(getLastArrayElement($callable), getFirstArrayElement($callable), false, ...$arguments);
        } elseif ($callable instanceof \Closure) {
            return $callable(...$arguments);
        } elseif (true === is_string($callable)) {
            return self::handle($callable, null, null, ...$arguments);
        }

        throw new InvalidArgumentException('Invalid parameters provided for "%s". Unsure how to handle call.', null, null, __METHOD__);
    }

    /**
     * Call a global function (if exists) with specified arguments.
     *
     * @param string   $function  A global function name
     * @param ...mixed $arguments Arguments to pass to the global function
     *
     * @return mixed
     */
    public static function func($function, ...$arguments)
    {
        return self::handle($function, null, null, ...$arguments);
    }

    /**
     * Call an object method (if exists) with specified arguments.
     *
     * @param string|object $object    An object instance or a class name
     * @param string        $method    An accessible object method name
     * @param mixed,...     $arguments Arguments to pass to the object method
     *
     * @return mixed
     */
    public static function method($object, $method, ...$arguments)
    {
        return self::handle($method, $object, false, ...$arguments);
    }

    /**
     * Call an static object method (if exists) with specified arguments.
     *
     * @param string|object $object    An object instance or a class name
     * @param string        $method    An accessible object method name
     * @param mixed,...     $arguments Arguments to pass to the object method
     *
     * @return mixed
     */
    public static function staticMethod($object, $method, ...$arguments)
    {
        return self::handle($method, $object, true, ...$arguments);
    }

    /**
     * Handle calling a function/method.
     *
     * @param string|null        $method    An available global function or object method name
     * @param string|object|null $object    An object instance or a class name
     * @param bool               $static    Whether this is a static function or not
     * @param mixed,...          $arguments Arguments to pass to the object method
     *
     * @internal
     *
     * @return mixed
     */
    public static function handle($method = null, $object = null, $static = false, ...$arguments)
    {
        $call = self::validateCall($method, $object, $static);

        return call_user_func_array($call, $arguments);
    }

    /**
     * Performs validations on request prior to calling it.
     *
     * @param string|null        $method An available global function or object method name
     * @param string|object|null $object An object class name
     * @param bool|null          $static Whether this is a static call or not
     *
     * @internal
     *
     * @throws InvalidArgumentException
     *
     * @return array|string
     */
    protected static function validateCall($method = null, $object = null, $static = null)
    {
        if (null === $method && null === $object && null === $static) {
            throw new InvalidArgumentException('Invalid parameters provided for %s.', null, null, __METHOD__);
        }

        if (null !== $method && null === $object && null === $static) {
            return self::validateFunction($method);
        }

        return self::validateMethod($method, self::validateClass($object, $static), $static);
    }

    /**
     * Validates the requested global function name exists.
     *
     * @param string $function
     *
     * @internal
     *
     * @throws BadFunctionCallException
     *
     * @return string
     */
    protected static function validateFunction($function)
    {
        if (false === function_exists($function)) {
            throw new BadFunctionCallException('The requested function %s does not exist.', null, null, (string) $function);
        }

        return (string) $function;
    }

    /**
     * Validate the requested object instance or class name exists.
     *
     * @param string|object $object The object instance or class name
     * @param bool          $static Whether this is a static call or not
     *
     * @internal
     *
     * @throws BadFunctionCallException
     *
     * @return string|object
     */
    protected static function validateClass($object, $static)
    {
        $class = (string) (true === is_string($object) ? $object : get_class($object));

        if (false === class_exists($class)) {
            throw new BadFunctionCallException('The requested class "%s" cannot be found in "%s".', null, null,
                (string) $class, (string) __METHOD__);
        }

        return true === $static ? $class : $object;
    }

    /**
     * Validate the requested object instance or class name exists.
     *
     * @param string        $method The method name
     * @param string|object $object The object instance or class name
     * @param bool          $static Whether this is a static call or not
     *
     * @internal
     *
     * @throws BadFunctionCallException
     *
     * @return string|array
     */
    protected static function validateMethod($method, $object, $static)
    {
        $call = (true === $static ? $object.'::'.$method : [$object, $method]);

        if (false === method_exists($object, $method) || false === is_callable($call)) {
            throw new BadFunctionCallException('The requested %s %s does not exist for class %s (or is not callable).',
                null, null, (true === $static ? 'static function' : 'method'), $method, $object);
        }

        return $call;
    }
}

/* EOF */
