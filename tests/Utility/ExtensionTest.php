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
use SR\Wonka\Utility\Extension;

class ExtensionTest extends WonkaTestCase
{
    public function testThrowsExceptionOnInstantiation()
    {
        $this->setExpectedException(
            'SR\Wonka\Exception\RuntimeException',
            'Cannot instantiate static class SR\Wonka\Utility\Extension'
        );

        new Extension();
    }

    public function testAreAnyEnabledSuccess()
    {
        static::assertEquals(
            'igbinary',
            Extension::areAnyEnabled('not-real-extension', 'igbinary', 'mbstring')
        );
    }

    public function testAreAnyEnabledFailure()
    {
        static::assertFalse(
            Extension::areAnyEnabled('not-real-extension-1', 'not-real-extension-1', 'not-real-extension-1')
        );
    }

    public function testAreAllEnabledSuccess()
    {
        static::assertTrue(
            Extension::areAllEnabled('mysqli', 'json')
        );
    }

    public function testAreAllEnabledFailure()
    {
        static::assertFalse(
            Extension::areAllEnabled('memcached', 'igbinary', 'twig', 'mongo', 'pdo_mysql', 'mysql', 'not-real')
        );
    }

    public function testIgbinaryIsEnabled()
    {
        static::assertTrue(Extension::hasIgbinary());
    }

    public function testJsonIsEnabled()
    {
        static::assertTrue(Extension::hasJson());
    }

    public function testReflectIsEnabled()
    {
        static::assertTrue(Extension::isEnabled('Reflection'));
    }

    public function testUnknownExtensionIsNotEnabled()
    {
        static::assertFalse(Extension::isEnabled('this-extension-does-not-exist'));
    }

    public function testExceptionOnEmptyString()
    {
        $this->setExpectedException(
            'SR\Wonka\Exception\RuntimeException',
            'Cannot check extension availability against empty string in SR\Wonka\Utility\Extension.'
        );

        Extension::isEnabled('');
    }
}

/* EOF */
