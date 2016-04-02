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

use SR\Wonka\Serializer\SerializerFactory;
use SR\Wonka\Utility\UnitTest\WonkaTestCase;

/**
 * Class SerializerFactoryTest.
 */
class SerializerFactoryTest extends WonkaTestCase
{
    public function testInstantiationException()
    {
        $this->setExpectedException('SR\Exception\RuntimeException');

        new SerializerFactory();
    }

    public function testCreateTypes()
    {
        static::assertInstanceOf(
            'SR\Wonka\Serializer\SerializerIgbinary',
            SerializerFactory::create(SerializerFactory::SERIALIZER_IGBINARY)
        );

        static::assertInstanceOf(
            'SR\Wonka\Serializer\SerializerJson',
            SerializerFactory::create(SerializerFactory::SERIALIZER_JSON)
        );

        static::assertInstanceOf(
            'SR\Wonka\Serializer\SerializerNative',
            SerializerFactory::create(SerializerFactory::SERIALIZER_NATIVE)
        );
    }

    public function testAutoTypeWithIgbinary()
    {
        if (extension_loaded('igbinary')) {
            static::assertInstanceOf(
                'SR\Wonka\Serializer\SerializerIgbinary',
                SerializerFactory::create(SerializerFactory::SERIALIZER_AUTO)
            );
        }
    }

    public function testAutoTypeWithoutIgbinary()
    {
        if (!extension_loaded('igbinary')) {
            static::assertInstanceOf(
                'SR\Wonka\Serializer\SerializerNative',
                SerializerFactory::create(SerializerFactory::SERIALIZER_NATIVE)
            );
        }
    }
}

/* EOF */
