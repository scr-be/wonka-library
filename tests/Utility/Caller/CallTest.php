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

namespace SR\Wonka\Tests\Utility\Caller;

use SR\Wonka\Utility\UnitTest\WonkaTestCase;
use SR\Wonka\Utility\Caller\Call;

class CallTest extends WonkaTestCase
{
    public function testShouldThrowExceptionOnInstantiation()
    {
        $this->setExpectedException(
            'SR\Exception\RuntimeException',
            'Cannot instantiate static class SR\Wonka\Utility\Caller\Call.'
        );

        new Call();
    }

    public function testShouldThrowExceptionOnInvalidFunctionCall()
    {
        $this->setExpectedException(
            'SR\Exception\BadFunctionCallException'
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
            'SR\Exception\BadFunctionCallException'
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
            'SR\Exception\BadFunctionCallException'
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
            'SR\Exception\InvalidArgumentException',
            'Invalid parameters provided for SR\Wonka\Utility\Caller\Call::validateCall.'
        );

        Call::func(null);
    }

    public function testStaticCallOnInvalidClass()
    {
        $this->setExpectedException(
            'SR\Exception\BadFunctionCallException',
            'The requested class "ThisCallDoesNotExistAnywhereIHopeIfYouMadeThisClassWhy" cannot be found in "SR\Wonka\Utility\Caller\Call::validateClass".'
        );

        Call::staticMethod('ThisCallDoesNotExistAnywhereIHopeIfYouMadeThisClassWhy', 'someMethod', 'arg1', 'arg2');
    }

    public function testInvalidCallToSomething()
    {
        $this->setExpectedException(
            'SR\Exception\InvalidArgumentException',
            'Invalid parameters provided for "SR\Wonka\Utility\Caller\Call::generic". Unsure how to handle call.'
        );

        Call::generic(42);
    }
}

/* EOF */
