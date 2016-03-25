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

namespace SR\Wonka\Tests\Utility;

use SR\Wonka\Utility\UnitTest\WonkaTestCase;
use SR\Wonka\Utility\Plode\Plode;
use SR\Wonka\Exception\BadFunctionCallException;

class PlodeTest extends WonkaTestCase
{
    public function testShouldThrowExceptionOnInstantiation()
    {
        $this->setExpectedException(
            'RuntimeException',
            'Cannot instantiate static class SR\Wonka\Utility\Plode\Plode.'
        );
        new Plode();
    }

    public function testShouldImplodeArrayToString()
    {
        $result = Plode::im(['one', 'two', 'three'], Plode::SEPARATOR_COMMA);
        static::assertEquals($result, 'one,two,three');
    }

    public function testShouldExplodeStringToArray()
    {
        $result = Plode::ex('one,two,three', Plode::SEPARATOR_COMMA);
        static::assertEquals($result, ['one', 'two', 'three']);
    }

    public function testShouldThrowExceptionOnInvalidArgumentCountNotEnoughMagicMethodCall()
    {
        $this->setExpectedException(
            'BadFunctionCallException',
            'Expected method format is "[im|ex]OnSeparator" for example "imOnComma".'
        );
        Plode::imOnComma();
    }

    public function testShouldThrowExceptionOnInvalidArgumentCountTooManyMagicMethodCall()
    {
        $this->setExpectedException(
            'BadFunctionCallException',
            'Expected method format is "[im|ex]OnSeparator" for example "imOnComma".'
        );
        Plode::imOnComma('one', 'two');
    }

    public function testShouldThrowExceptionOnInvalidStrSizeMagicMethodCall()
    {
        $this->setExpectedException(
            'BadFunctionCallException',
            'Expected method format is "[im|ex]OnSeparator" for example "imOnComma".'
        );
        Plode::a();
    }

    public function testShouldThrowExceptionOnInvalidStr01MagicMethodCall()
    {
        $this->setExpectedException(
            'BadFunctionCallException',
            'Valid method prefixes are "im" for "implode" and "ex" for "explode".'
        );
        Plode::aaOnComma('one,two,three');
    }

    /**
     * @expectedException        BadFunctionCallException
     * @expectedExceptionMessage Expected method format is "[im|ex]OnSeparator" for example "imOnComma" but exAaComma
     *                           was provided.
     */
    public function testShouldThrowExceptionOnInvalidStr23MagicMethodCall()
    {
        Plode::exAAComma('one,two,three');
    }

    public function testShouldThrowExceptionOnInvalidStr4nMagicMethodCall()
    {
        $this->setExpectedException(
            'BadFunctionCallException',
            'Invalid separator type of aa provided.'
        );
        Plode::exOnAA('one,two,three');
    }

    public function testShouldImplodeArrayToStringUsingMagicMethodWithCommaSeparator()
    {
        $result = Plode::imOnComma(['one', 'two', 'three']);
        static::assertEquals($result, 'one,two,three');
    }

    public function testShouldImplodeArrayToStringUsingMagicMethodWithColonSeparator()
    {
        $result = Plode::imOnColon(['one', 'two', 'three']);
        static::assertEquals($result, 'one:two:three');
    }
}

/* EOF */
