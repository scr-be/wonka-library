<?php

/*
 * This file is part of the scribe/wonka-bundle.
 *
 * (c) Scribe Inc. <rmf@scr.be>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\Wonka\Tests\Utility\System\Cpu;

use Scribe\Wonka\Utility\System\Cpu\SystemCpu;
use Scribe\Wonka\Utility\UnitTest\WonkaTestCase;

class SystemCpuTest extends WonkaTestCase
{
    /**
     * @var SystemCpu
     */
    protected $s;

    public function setUp()
    {
        $this->s = new SystemCpu();

        parent::setUp();
    }

    public function testGetSystemPlatform()
    {
        static::assertNotNull($this->s->getCoreCount());
    }

    public function testGetLoadAverages()
    {
        $l = $this->s->getLoadAverages();

        static::assertInternalType('int', $l[0]);
        static::assertInternalType('float', $l[1]);
        static::assertInternalType('float', $l[2]);
        static::assertInternalType('float', $l[3]);
        static::assertInternalType('float', $l[4]);
    }

    public function testGetLoadAveragesAsPercent()
    {
        $l = $this->s->getLoadAveragesAsPercent();

        static::assertInternalType('int', $l[0]);
        static::assertInternalType('float', $l[1]);
        static::assertInternalType('float', $l[2]);
        static::assertInternalType('float', $l[3]);
        static::assertInternalType('float', $l[4]);
    }
}

/* EOF */
