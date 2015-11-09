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

use Scribe\Wonka\Serializer\SerializerFactory;
use Scribe\Wonka\Utility\UnitTest\WonkaTestCase;

/**
 * Class SerializerFactoryTest.
 */
class SerializerFactoryTest extends WonkaTestCase
{
    public function testInstantiationException()
    {
        $this->setExpectedException('Scribe\Wonka\Exception\RuntimeException');

        new SerializerFactory();
    }

    public function testCreateTypes()
    {
        static::assertInstanceOf(
            'Scribe\Wonka\Serializer\SerializerIgbinary',
            SerializerFactory::create(SerializerFactory::SERIALIZER_IGBINARY)
        );

        static::assertInstanceOf(
            'Scribe\Wonka\Serializer\SerializerJson',
            SerializerFactory::create(SerializerFactory::SERIALIZER_JSON)
        );

        static::assertInstanceOf(
            'Scribe\Wonka\Serializer\SerializerNative',
            SerializerFactory::create(SerializerFactory::SERIALIZER_NATIVE)
        );
    }

    public function testAutoTypeWithIgbinary()
    {
        if (extension_loaded('igbinary')) {
            static::assertInstanceOf(
                'Scribe\Wonka\Serializer\SerializerIgbinary',
                SerializerFactory::create(SerializerFactory::SERIALIZER_AUTO)
            );
        }
    }

    public function testAutoTypeWithoutIgbinary()
    {
        if (!extension_loaded('igbinary')) {
            static::assertInstanceOf(
                'Scribe\Wonka\Serializer\SerializerNative',
                SerializerFactory::create(SerializerFactory::SERIALIZER_NATIVE)
            );
        }
    }
}

/* EOF */
