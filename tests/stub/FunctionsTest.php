<?php

/*
 * This file is part of the `src-run/wonka-library` project.
 *
 * (c) Rob Frawley 2nd <rmf@src.run>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace SR\Wonka\Tests;

use SR\Wonka\Utility\UnitTest\WonkaTestCase;

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

    public function testIsCountableEqual()
    {
        $a = ['a', 'b', 1, '2'];

        static::assertNotTrue(\isCountableEqual($a, 5));
        static::assertTrue(\isCountableEqual($a, 4));
        static::assertNull(\isCountableEqual('a', 4));
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

        static::assertTrue(isIterable($a));
        static::assertTrue(isIterableEmpty($a));
        static::assertFalse(isIterableNotEmpty($a));
        static::assertEquals(0, countableSize($a));
    }

    public function testIsArrayNotEmpty()
    {
        $a = [1, 2, 3];

        static::assertTrue(isIterable($a));
        static::assertFalse(isIterableEmpty($a));
        static::assertTrue(isIterableNotEmpty($a));
        static::assertEquals(3, countableSize($a));
        static::assertEquals(1, getArrayElement(0, $a));
    }

    public function testIsIteratorArrayAccess()
    {
        $a = $this->getMockBuilder('\ArrayAccess')
            ->getMockForAbstractClass();

        static::assertTrue(isIterable($a));
        static::assertNull(isIterableEmpty($a));
        static::assertNull(isIterableNotEmpty($a));
    }

    public function testIsIteratorCountable()
    {
        $a = $this->getMockBuilder('\Countable')
            ->getMockForAbstractClass();

        static::assertTrue(isIterable($a));
        static::assertTrue(isIterableEmpty($a));
        static::assertFalse(isIterableNotEmpty($a));
    }

    public function testIsIteratorNotIterable()
    {
        $a = $this->getMockBuilder('\SR\Exception\Runtime\RuntimeException')
            ->getMockForAbstractClass();

        static::assertFalse(isIterable($a));
        static::assertNull(isIterableEmpty($a));
        static::assertNull(isIterableNotEmpty($a));
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

        $this->setExpectedException('\SR\Exception\Logic\InvalidArgumentException');

        static::assertTrue(isNullOrEmptyStr(null));
    }

    public function testGetArrayFirstOnNonArrayAccess()
    {
        static::assertNull(getFirstArrayElement('not-iterable'));
    }

    public function testGetArrayLastOnNonArrayAccess()
    {
        static::assertNull(getLastArrayElement('not-iterable'));
    }
}

/* EOF */
