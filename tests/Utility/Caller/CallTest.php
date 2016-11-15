<?php

/*
 * This file is part of the `src-run/wonka-library` project.
 *
 * (c) Rob Frawley 2nd <rmf@src.run>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace SR\Wonka\Tests\Utility\Caller;

use SR\Wonka\Utility\Caller\Call;
use SR\Wonka\Utility\UnitTest\WonkaTestCase;

class CallTest extends WonkaTestCase
{
    public function testShouldThrowExceptionOnInvalidFunctionCall()
    {
        $this->expectException('SR\Exception\Logic\BadFunctionCallException');

        Call::func('this_function_does_not_exist');
    }

    public function testShouldResultInPhpErrorOnInvalidFunctionArgument()
    {
        $this->expectException('PHPUnit_Framework_Error');
        $this->expectExceptionMessage('strtolower() expects parameter 1 to be string, array given');

        $result = Call::func('strtolower', ['an', 'array']);
        static::assertFalse($result);
    }

    public function testShouldReturnResultOnFunctionCall()
    {
        $phpVersion = Call::func('phpversion');

        static::assertEquals($phpVersion, phpversion());

        $phpVersion = Call::this('phpversion');

        static::assertEquals($phpVersion, phpversion());
    }

    public function testShouldReturnResultOnFunctionCallWithSingleStringArgument()
    {
        $string = Call::func('strtolower', 'STRING');

        static::assertEquals($string, 'string');

        $string = Call::this('strtolower', 'STRING');

        static::assertEquals($string, 'string');
    }

    public function testShouldReturnResultOnFunctionCallWithSingleArrayArgument()
    {
        $array = Call::func('array_keys', ['one', 'two', 'three']);

        static::assertEquals($array, [0, 1, 2]);

        $array = Call::this('array_keys', ['one', 'two', 'three']);

        static::assertEquals($array, [0, 1, 2]);
    }

    public function testShouldReturnResultOnFunctionCallWithMultipleStringArguments()
    {
        $array = Call::func('explode', ',', 'one,two,three');

        static::assertEquals($array, ['one', 'two', 'three']);

        $array = Call::this('explode', ',', 'one,two,three');

        static::assertEquals($array, ['one', 'two', 'three']);
    }

    public function testShouldReturnResultOnFunctionCallWithMultipleMixedArguments()
    {
        $string = Call::func('implode', ',', ['one', 'two', 'three']);

        static::assertEquals($string, 'one,two,three');

        $string = Call::this('implode', ',', ['one', 'two', 'three']);

        static::assertEquals($string, 'one,two,three');
    }

    public function testShouldThrowExceptionOnInvalidMethodCall()
    {
        $this->expectException('SR\Exception\Logic\BadFunctionCallException');
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
        $this->expectException('SR\Exception\Logic\BadFunctionCallException');

        Call::staticMethod('\Datetime', 'static_method_does_not_exist');
    }

    public function testShouldReturnResultOnStaticMethodCall()
    {
        $time = time();
        $result = Call::staticMethod('\DateTime', 'createFromFormat', 'Y', $time);

        static::assertEquals($result, \DateTime::createFromFormat('Y', $time));

        $time = time();
        $result = Call::this(['\DateTime', 'createFromFormat'], 'Y', $time);

        static::assertEquals($result, \DateTime::createFromFormat('Y', $time));
    }

    public function testValidateCall()
    {
        $this->expectException('SR\Exception\Logic\InvalidArgumentException');
        $this->expectExceptionMessageRegExp('{Could not validate call.*}');

        Call::func(null);
    }

    public function testStaticCallOnInvalidClass()
    {
        $this->expectException('SR\Exception\Logic\BadFunctionCallException');
        $this->expectExceptionMessageRegExp('{Could not validate call class.*}');

        Call::staticMethod('ThisCallDoesNotExistAnywhereIHopeIfYouMadeThisClassWhy', 'someMethod', 'arg1', 'arg2');
    }

    public function testInvalidCallToSomething()
    {
        $this->expectException('SR\Exception\Logic\InvalidArgumentException');
        $this->expectExceptionMessageRegExp('{Invalid call requested.*}');

        Call::this(42);
    }

    public function testCallClosure()
    {
        $closure = function () {
            return 'closure: '.__METHOD__;
        };

        $return = Call::this($closure);
        $this->assertContains('closure: ', $return);
    }
}

/* EOF */
