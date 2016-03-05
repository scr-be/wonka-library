<?php

/*
 * This file is part of the Wonka Library.
 *
 * (c) Scribe Inc.     <oss@src.run>
 * (c) Rob Frawley 2nd <rmf@src.run>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\Wonka\Tests\Utility\System\Platform;

use Scribe\Wonka\Utility\System\Platform;
use Scribe\Wonka\Utility\UnitTest\WonkaTestCase;

class PlatformTest extends WonkaTestCase
{
    public function testShouldThrowExceptionOnInstantiation()
    {
        $this->setExpectedException('RuntimeException');

        new Platform();
    }

    public function testname()
    {
        if (strtoupper(substr(PHP_OS, 0, 3)) == 'LIN') {
            static::assertEquals('LIN', Platform::name());
        } elseif (strtoupper(substr(PHP_OS, 0, 3)) == 'WIN') {
            static::assertEquals('WIN', Platform::name());
        } else {
            static::markTestSkipped('Not Linux/Windows OS.');
        }
    }

    public function testis()
    {
        if (strtoupper(substr(PHP_OS, 0, 3)) == 'LIN') {
            static::assertTrue(Platform::is('LINUX'));
            static::assertFalse(Platform::is('WINDOWS'));
            static::assertFalse(Platform::isNot('LINUX'));
            static::assertTrue(Platform::isNot('WINDOWS'));
        } elseif (strtoupper(substr(PHP_OS, 0, 3)) == 'WIN') {
            static::assertFalse(Platform::is('LINUX'));
            static::assertTrue(Platform::is('WINDOWS'));
            static::assertTrue(Platform::isNot('LINUX'));
            static::assertFalse(Platform::isNot('WINDOWS'));
        } else {
            static::markTestSkipped('Not Linux/Windows OS.');
        }
    }
}

/* EOF */
