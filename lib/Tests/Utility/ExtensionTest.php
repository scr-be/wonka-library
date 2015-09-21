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

use Scribe\Wonka\Utility\UnitTest\WonkaUnitTestCase;
use Scribe\Wonka\Utility\Extension;

class ExtensionTest extends WonkaUnitTestCase
{
    public function testThrowsExceptionOnInstantiation()
    {
        $this->setExpectedException(
            'Scribe\Wonka\Exception\RuntimeException',
            'Cannot instantiate static class Scribe\Wonka\Utility\Extension'
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
            Extension::areAllEnabled('igbinary', 'twig')
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
            'Scribe\Wonka\Exception\RuntimeException',
            'Cannot check extension availability against empty string in Scribe\Wonka\Utility\Extension.'
        );

        Extension::isEnabled('');
    }
}

/* EOF */
