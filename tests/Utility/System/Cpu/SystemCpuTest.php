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

namespace SR\Wonka\Tests\Utility\System\Cpu;

use SR\Wonka\Utility\System\Stats;
use SR\Wonka\Utility\UnitTest\WonkaTestCase;

class StatsTest extends WonkaTestCase
{
    public function testname()
    {
        static::assertNotNull(Stats::getCoreCount());
    }

    public function testGetLoadAverages()
    {
        $l = Stats::getLoadAverages();

        static::assertInternalType('int', $l[0]);
        static::assertInternalType('float', $l[1]);
        static::assertInternalType('float', $l[2]);
        static::assertInternalType('float', $l[3]);
        static::assertInternalType('float', $l[4]);
    }

    public function testGetLoadAveragesAsPercent()
    {
        $l = Stats::getLoadAveragesAsPercent();

        static::assertInternalType('int', $l[0]);
        static::assertInternalType('float', $l[1]);
        static::assertInternalType('float', $l[2]);
        static::assertInternalType('float', $l[3]);
        static::assertInternalType('float', $l[4]);
    }
}

/* EOF */
