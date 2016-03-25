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
use SR\Wonka\Utility\Arrays;

class ArraysTest extends WonkaTestCase
{
    public function testShouldThrowExceptionOnInstantiation()
    {
        $this->setExpectedException(
            'SR\Wonka\Exception\RuntimeException',
            'Cannot instantiate static class SR\Wonka\Utility\Arrays.'
        );

        new Arrays();
    }

    public function testIsHash()
    {
        $data = [
            [['a', 'b', 'c', 'd'], false],
            [[0 => 'a', 1 => 'b', 2 => 'c', 3 => 'd'], false],
            [[20 => 'a', 3 => 'b', 12 => 'c', 9 => 'd'], true],
            [['abc' => 'a', 'def' => 'b', 'ghi' => 'c', 'jkl' => 'd'], true],
        ];

        foreach ($data as $d) {
            $actual = Arrays::isHash($d[0]);
            static::assertEquals($d[1], $actual);
        }
    }

    public function testIsHashException()
    {
        $this->setExpectedException(
            'SR\Wonka\Exception\RuntimeException',
            'There is no way to determine if an empty array is a hash or not.'
        );

        Arrays::isHash([]);
    }
}

/* EOF */
