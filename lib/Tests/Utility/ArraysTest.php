<?php

/*
 * This file is part of the scribe/wonka-bundle.
 *
 * (c) Scribe Inc. <rmf@scr.be>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\Wonka\Tests\Utility;

use Scribe\Wonka\Utility\UnitTest\WonkaTestCase;
use Scribe\Wonka\Utility\Arrays;

class ArraysTest extends WonkaTestCase
{
    public function testShouldThrowExceptionOnInstantiation()
    {
        $this->setExpectedException(
            'Scribe\Wonka\Exception\RuntimeException',
            'Cannot instantiate static class Scribe\Wonka\Utility\Arrays.'
        );

        new Arrays();
    }

    public function testIsHash()
    {
        $data = [
            [['a', 'b', 'c', 'd'], false],
            [[0 => 'a',1 => 'b',2 => 'c',3 => 'd'], false],
            [[20 => 'a',3 => 'b',12 => 'c',9 => 'd'], true],
            [['abc' => 'a','def' => 'b','ghi' => 'c','jkl' => 'd'], true],
        ];

        foreach ($data as $d) {
            $actual = Arrays::isHash($d[0]);
            static::assertEquals($d[1], $actual);
        }
    }

    public function testIsHashException()
    {
        $this->setExpectedException(
            'Scribe\Wonka\Exception\RuntimeException',
            'There is no way to determine if en empty array is a hash or not.'
        );

        Arrays::isHash([]);
    }
}

/* EOF */
