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
    public function testCompareStrict()
    {
        $a = ['a', 'b', 1, '2'];
        $b = ['a', 'b', '1', '2'];

        static::assertNotTrue(\compare_strict($a, $b));
        static::assertNotTrue(\compare_strict($b, $a));
        static::assertTrue(\compare_strict($a, $a));
        static::assertTrue(\compare_strict($b, $b));
    }

    public function testCompareStrictException()
    {
        $this->setExpectedException('\RuntimeException');
        \compare_strict();
    }

    public function testIsIteratorArray()
    {
        $a = [];

        static::assertTrue(\is_iterable($a));
        static::assertTrue(\is_iterable_empty($a));
        static::assertFalse(\is_iterable_not_empty($a));
        static::assertEquals(0, get_iterable_count($a));
    }

    public function testIsIteratorArrayNotEmpty()
    {
        $a = [1, 2, 3];

        static::assertTrue(\is_iterable($a));
        static::assertFalse(\is_iterable_empty($a));
        static::assertTrue(\is_iterable_not_empty($a));
        static::assertEquals(3, get_iterable_count($a));
        static::assertEquals(1, get_iterable_value_by_key(0, $a));
    }

    public function testIsIteratorArrayAccess()
    {
        $a = $this->getMockBuilder('\ArrayAccess')
            ->getMockForAbstractClass();

        static::assertTrue(\is_iterable($a));
        static::assertFalse(\is_iterable_empty($a));
        static::assertTrue(\is_iterable_not_empty($a));
    }

    public function testIsIteratorCountable()
    {
        $a = $this->getMockBuilder('\Countable')
            ->getMockForAbstractClass();

        static::assertTrue(\is_iterable($a));
        static::assertTrue(\is_iterable_empty($a));
        static::assertFalse(\is_iterable_not_empty($a));
    }

    public function testIsIteratorNotIterable()
    {
        $a = $this->getMockBuilder('\Scribe\Wonka\Exception\RuntimeException')
            ->getMockForAbstractClass();

        static::assertFalse(\is_iterable($a));
        static::assertTrue(\is_iterable_empty($a));
        static::assertFalse(\is_iterable_not_empty($a));
    }

    public function testIsNullOrEmpty()
    {
        static::assertTrue(\is_null_or_empty([]));
        static::assertTrue(\is_null_or_empty(null));
        static::assertTrue(\is_null_or_empty(''));
        static::assertTrue(\is_null_or_empty_string(null));
        static::assertTrue(\is_null_or_empty_string(''));
    }
}

/* EOF */
