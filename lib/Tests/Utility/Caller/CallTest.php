<?php

/*
 * This file is part of the scribe/wonka-bundle.
 *
 * (c) Scribe Inc. <rmf@scr.be>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\Wonka\Tests\Utility\Caller;

use Scribe\Wonka\Utility\UnitTest\WonkaTestCase;
use Scribe\Wonka\Utility\Caller\Call;

class CallTest extends WonkaTestCase
{
    public function testShouldThrowExceptionOnInstantiation()
    {
        $this->setExpectedException(
            'Scribe\Wonka\Exception\RuntimeException',
            'Cannot instantiate static class Scribe\Wonka\Utility\Caller\Call.'
        );

        new Call();
    }

    public function testShouldThrowExceptionOnInvalidFunctionCall()
    {
        $this->setExpectedException(
            'Scribe\Wonka\Exception\BadFunctionCallException'
        );

        Call::func('this_function_does_not_exist');
    }

    public function testShouldResultInPhpErrorOnInvalidFunctionArgument()
    {
        $this->setExpectedException(
            'PHPUnit_Framework_Error',
            'strtolower() expects parameter 1 to be string, array given'
        );

        $result = Call::func('strtolower', ['an', 'array']);
        static::assertFalse($result);
    }

    public function testShouldReturnResultOnFunctionCall()
    {
        $phpVersion = Call::func('phpversion');

        static::assertEquals($phpVersion, phpVersion());
    }

    public function testShouldReturnResultOnFunctionCallWithSingleStringArgument()
    {
        $string = Call::func('strtolower', 'STRING');

        static::assertEquals($string, 'string');
    }

    public function testShouldReturnResultOnFunctionCallWithSingleArrayArgument()
    {
        $array = Call::func('array_keys', ['one', 'two', 'three']);

        static::assertEquals($array, [0, 1, 2]);
    }

    public function testShouldReturnResultOnFunctionCallWithMultipleStringArguments()
    {
        $array = Call::func('explode', ',', 'one,two,three');

        static::assertEquals($array, ['one', 'two', 'three']);
    }

    public function testShouldReturnResultOnFunctionCallWithMultipleMixedArguments()
    {
        $string = Call::func('implode', ',', ['one', 'two', 'three']);

        static::assertEquals($string, 'one,two,three');
    }

    public function testShouldThrowExceptionOnInvalidMethodCall()
    {
        $this->setExpectedException(
            'Scribe\Wonka\Exception\BadFunctionCallException'
        );
        $exception = new \Exception();

        Call::method($exception, 'method_does_not_exist');
    }

    public function testShouldReturnResultOnMethodCall()
    {
        $exception = new \Exception('This is an exception');
        $result = Call::method($exception, 'getMessage');

        static::assertEquals($result, 'This is an exception');
    }

    public function testShouldThrowExceptionOnInvalidStaticMethodCall()
    {
        $this->setExpectedException(
            'Scribe\Wonka\Exception\BadFunctionCallException'
        );

        Call::staticMethod('\Datetime', 'static_method_does_not_exist');
    }

    public function testShouldReturnResultOnStaticMethodCall()
    {
        $time = time();
        $result = Call::staticMethod('\Datetime', 'createFromFormat', 'Y', $time);

        static::assertEquals($result, \Datetime::createFromFormat('Y', $time));
    }

    public function testValidateCall()
    {
        $this->setExpectedException(
            'Scribe\Wonka\Exception\InvalidArgumentException',
            'Invalid parameters provided for Scribe\Wonka\Utility\Caller\Call::validateCall.'
        );

        Call::func(null);
    }

    public function testStaticCallOnInvalidClass()
    {
        $this->setExpectedException(
            'Scribe\Wonka\Exception\BadFunctionCallException',
            'The requested class "ThisCallDoesNotExistAnywhereIHopeIfYouMadeThisClassWhy" cannot be found in "Scribe\Wonka\Utility\Caller\Call::validateClass".'
        );

        Call::staticMethod('ThisCallDoesNotExistAnywhereIHopeIfYouMadeThisClassWhy', 'someMethod', 'arg1', 'arg2');
    }

    public function testInvalidCallToSomething()
    {
        $this->setExpectedException(
            'Scribe\Wonka\Exception\InvalidArgumentException',
            'Invalid parameters provided for "Scribe\Wonka\Utility\Caller\Call::generic". Unsure how to handle call.'
        );

        Call::generic(42);
    }
}

/* EOF */
