<?php

/*
 * This file is part of the scribe/wonka-bundle.
 *
 * (c) Scribe Inc. <rmf@scr.be>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\Wonka\Tests\Utility\System\Platform;

use Scribe\Wonka\Utility\System\Platform\SystemPlatform;
use Scribe\Wonka\Utility\UnitTest\WonkaTestCase;

class SystemPlatformTest extends WonkaTestCase
{
    public function testShouldThrowExceptionOnInstantiation()
    {
        $this->setExpectedException('RuntimeException');

        new SystemPlatform();
    }

    public function testGetSystemPlatform()
    {
        if (strtoupper(substr(PHP_OS, 0, 3)) == 'LIN') {
            static::assertEquals('LIN', SystemPlatform::getSystemPlatform());
        } elseif (strtoupper(substr(PHP_OS, 0, 3)) == 'WIN') {
            static::assertEquals('WIN', SystemPlatform::getSystemPlatform());
        } else {
            static::markTestSkipped('Not Linux/Windows OS.');
        }
    }

    public function testIsSystemPlatform()
    {
        if (strtoupper(substr(PHP_OS, 0, 3)) == 'LIN') {
            static::assertTrue(SystemPlatform::isSystemPlatform('LINUX'));
            static::assertFalse(SystemPlatform::isSystemPlatform('WINDOWS'));
            static::assertFalse(SystemPlatform::isNotSystemPlatform('LINUX'));
            static::assertTrue(SystemPlatform::isNotSystemPlatform('WINDOWS'));
        } elseif (strtoupper(substr(PHP_OS, 0, 3)) == 'WIN') {
            static::assertFalse(SystemPlatform::isSystemPlatform('LINUX'));
            static::assertTrue(SystemPlatform::isSystemPlatform('WINDOWS'));
            static::assertTrue(SystemPlatform::isNotSystemPlatform('LINUX'));
            static::assertFalse(SystemPlatform::isNotSystemPlatform('WINDOWS'));
        } else {
            static::markTestSkipped('Not Linux/Windows OS.');
        }
    }
}

/* EOF */
