<?php

/*
 * This file is part of the scribe/wonka-bundle.
 *
 * (c) Scribe Inc. <rmf@scr.be>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\Wonka\Tests;

use Scribe\Wonka\Utility\UnitTest\WonkaTestCase;

/**
 * Class FunctionsTest.
 */
class FunctionsTest extends WonkaTestCase
{
    public function testIsEqual()
    {
        $a = ['a', 'b', 1, '2'];
        $b = ['a', 'b', '1', '2'];

        static::assertNotTrue(\isEqual($a, $b));
        static::assertNotTrue(\isEqual($b, $a));
        static::assertTrue(\isEqual($a, $a));
        static::assertTrue(\isEqual($b, $b));
    }

    public function testIsCollectionEquals()
    {
        $a = ['a', 'b', 1, '2'];
        $b = $c = $e = ['a', 'b', '1', '2'];
        $d = ['z', 'x'];

        static::assertNotTrue(isCollectionEquals($a, $b, $c, $d));
        static::assertNotTrue(isCollectionEquals($a, $b, $c));
        static::assertNotTrue(isCollectionEquals($a, $b));
        static::assertNotTrue(isCollectionEquals($c, $d));
        static::assertTrue(isCollectionEquals($b, $c, $e));
        static::assertTrue(isCollectionEquals($b, $c));
        static::assertTrue(isCollectionEquals($c, $e));
        static::assertTrue(isCollectionEquals($b, $e));
        static::assertTrue(isCollectionEquals($a, $a));
        static::assertTrue(isCollectionEquals($d, $d));
    }

    public function testCompareStrictException()
    {
        $this->setExpectedException('\InvalidArgumentException');
        isCollectionEquals();
    }

    public function testIsIterable()
    {
        $a = [];

        static::assertTrue(supportsIterable($a));
        static::assertTrue(isEmptyIterable($a));
        static::assertFalse(notEmptyIterable($a));
        static::assertEquals(0, getCountableSize($a));
    }

    public function testIsArrayNotEmpty()
    {
        $a = [1, 2, 3];

        static::assertTrue(supportsIterable($a));
        static::assertFalse(isEmptyIterable($a));
        static::assertTrue(notEmptyIterable($a));
        static::assertEquals(3, getCountableSize($a));
        static::assertEquals(1, getArrayElement(0, $a));
    }

    public function testIsIteratorArrayAccess()
    {
        $a = $this->getMockBuilder('\ArrayAccess')
            ->getMockForAbstractClass();

        static::assertTrue(supportsIterable($a));
        static::assertTrue(isEmptyIterable($a));
        static::assertFalse(notEmptyIterable($a));
    }

    public function testIsIteratorCountable()
    {
        $a = $this->getMockBuilder('\Countable')
            ->getMockForAbstractClass();

        static::assertTrue(supportsIterable($a));
        static::assertTrue(isEmptyIterable($a));
        static::assertFalse(notEmptyIterable($a));
    }

    public function testIsIteratorNotIterable()
    {
        $a = $this->getMockBuilder('\Scribe\Wonka\Exception\RuntimeException')
            ->getMockForAbstractClass();

        static::assertFalse(supportsIterable($a));
        static::assertNull(isEmptyIterable($a));
        static::assertNull(notEmptyIterable($a));
    }

    public function testIsNullOrEmpty()
    {
        static::assertTrue(isNullOrEmpty([]));
        static::assertTrue(isNullOrEmpty(null));
        static::assertTrue(isNullOrEmpty(''));
        static::assertFalse(notNullOrEmpty([]));
        static::assertFalse(notNullOrEmpty(null));
        static::assertFalse(notNullOrEmpty(''));

        static::assertTrue(isNullOrEmptyStr(''));
        static::assertFalse(notNullOrEmptyStr(''));

        $this->setExpectedException('\Scribe\Wonka\Exception\InvalidArgumentException');

        static::assertTrue(isNullOrEmptyStr(null));
    }
}

/* EOF */
