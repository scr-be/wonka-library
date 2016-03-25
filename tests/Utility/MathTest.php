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
use SR\Wonka\Utility\Math;

class MathTest extends WonkaTestCase
{
    public function testShouldThrowExceptionOnInstantiation()
    {
        $this->setExpectedException(
            'RuntimeException',
            'Cannot instantiate static class SR\Wonka\Utility\Math.'
        );

        new Math();
    }

    public function testShouldAcceptNoLessThanThreeArguments()
    {
        $this->setExpectedException(
            'SR\Wonka\Exception\InvalidArgumentException'
        );

        Math::toBase(0, 0, 0);
    }

    public function testToBase()
    {
        $provider = [
            [1,     10, 100, null, false, 10],
            [50,    50, 200, null, false, 200],
            [1.333, 10, 50,  2,    false, 6.67],
            [20,    10, 100, null, true,  100],
        ];

        foreach ($provider as $p) {
            $result = Math::toBase($p[0], $p[1], $p[2], $p[3], $p[4]);
            static::assertEquals($result, $p[5]);
        }
    }

    public function testToBaseShouldThrowExceptionOnZeroBase()
    {
        $this->setExpectedException(
            'InvalidArgumentException',
            'Cannot convert to a base of zero.'
        );

        Math::toBase(5, 0, 100);
    }
}

/* EOF */
