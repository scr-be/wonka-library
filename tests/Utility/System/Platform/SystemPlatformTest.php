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

namespace SR\Wonka\Tests\Utility\System\Platform;

use SR\Wonka\Utility\System\Platform\Platform;
use SR\Wonka\Utility\UnitTest\WonkaTestCase;

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
