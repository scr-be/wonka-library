<?php

/*
 * This file is part of the `src-run/wonka-library` project.
 *
 * (c) Rob Frawley 2nd <rmf@src.run>
 * (c) Scribe Inc      <scr@src.run>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace SR\Wonka\Utility\Caller;

use SR\Exception\Logic\BadFunctionCallException;
use SR\Exception\Logic\InvalidArgumentException;
use SR\Reflection\Inspect;

/**
 * Class Call.
 *
 * Static function collection to call either global functions or object methods
 * indirectly with checks that the requested function/method exists.
 */
class Call implements CallInterface
{
    /**
     * Call a global function or class method (if exists) or callable with specified arguments.
     *
     * @param string|array|\Closure $what  A global function name or class method (if exists) or callable
     * @param mixed,...             $arguments Arguments to pass to the global function
     *
     * @return mixed
     */
    public static function this($what, ...$arguments)
    {
        if (is_string($what)) {
            return static::handle($what, null, null, ...$arguments);
        }

        if (is_array($what)) {
            return static::handle(getLastArrayElement($what), getFirstArrayElement($what), false, ...$arguments);
        }

        if ($what instanceof \Closure) {
            return $what(...$arguments);
        }

        throw InvalidArgumentException::create()
            ->setMessage('Invalid call requested (got "%s" with parameters "%s").', var_export($what, true), var_export($arguments, true));
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
        return static::handle($function, null, null, ...$arguments);
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
        return static::handle($method, $object, false, ...$arguments);
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
        return static::handle($method, $object, true, ...$arguments);
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
    private static function handle($method = null, $object = null, $static = false, ...$arguments)
    {
        $call = static::validateCall($method, $object, $static);

        return call_user_func_array($call, $arguments);
    }

    /**
     * Performs validations on request prior to calling it.
     *
     * @param string|null        $method An available global function or object method name
     * @param string|object|null $object An object class name
     * @param bool|null          $static Whether this is a static call or not
     *
     * @throws InvalidArgumentException
     *
     * @return array|string
     */
    private static function validateCall($method = null, $object = null, $static = null)
    {
        if (null === $method && null === $object && null === $static) {
            throw InvalidArgumentException::create()
                ->setMessage('Could not validate call (got method "%s", object "%s", static "%s").', var_export($method, true), var_export($object, true), var_export($static, true));
        }

        if (null !== $method && null === $object && null === $static) {
            return static::validateFunction($method);
        }

        return static::validateMethod($method, static::validateClass($object, $static), $static);
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
    private static function validateFunction($function)
    {
        if (function_exists($function)) {
            return $function;
        }

        throw BadFunctionCallException::create()
            ->setMessage('Could not find call function (got "%s").', var_export($function, true));
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
    private static function validateClass($object, $static)
    {
        try {
            $class = Inspect::using($object)->nameQualified();
        } catch (\Exception $e) {
            throw BadFunctionCallException::create()
                ->setMessage('Could not validate call class (got "%s" with message "%s").', var_export($object, true), $e->getMessage());
        }

        return $static ? $class : $object;
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
    private static function validateMethod($method, $object, $static)
    {
        $callable = $static ? $object.'::'.$method : [$object, $method];

        if (method_exists($object, $method) && is_callable($callable)) {
            return $callable;
        }

        throw BadFunctionCallException::create('Could not validate call method.');
    }
}

/* EOF */
