<?php

/*
 * This file is part of the scribe/wonka-bundle.
 *
 * (c) Scribe Inc. <rmf@scr.be>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\Wonka\Tests\Utility\Serializer;

use Scribe\Wonka\Utility\UnitTest\WonkaTestCase;
use Scribe\Wonka\Utility\Serializer\Serializer;

class SerializerTest extends WonkaTestCase
{
    public function testThrowsExceptionOnInstantiation()
    {
        $this->setExpectedException(
            'Scribe\Wonka\Exception\RuntimeException',
            'Cannot instantiate static class Scribe\Wonka\Utility\Serializer\Serializer'
        );

        new Serializer();
    }

    public function testSerializerIgbinary()
    {
        $expectedUnserialized = [1, 'something', ['2, 3', 4]];
        $expectedSerialized = igbinary_serialize($expectedUnserialized);

        Serializer::setSerializer(Serializer::SERIALIZE_METHOD_IGBINARY, Serializer::UNSERIALIZE_METHOD_IGBINARY);
        $serialized = Serializer::sleep($expectedUnserialized);
        $unserialized = Serializer::wake($serialized);

        static::assertEquals($expectedSerialized, $serialized);
        static::assertEquals($expectedUnserialized, $unserialized);
    }

    public function testSerializerJson()
    {
        $expectedUnserialized = [1, 'something', ['2, 3', 4]];
        $expectedSerialized = json_encode($expectedUnserialized);

        Serializer::setSerializer(Serializer::SERIALIZE_METHOD_JSON, Serializer::UNSERIALIZE_METHOD_JSON);
        $serialized = Serializer::sleep($expectedUnserialized);
        $unserialized = Serializer::wake($serialized);

        static::assertEquals($expectedSerialized, $serialized);
        static::assertEquals($expectedUnserialized, $unserialized);
    }

    public function testSerializerNative()
    {
        $expectedUnserialized = [1, 'something', ['2, 3', 4]];
        $expectedSerialized = serialize($expectedUnserialized);

        Serializer::setSerializer(Serializer::SERIALIZE_METHOD_NATIVE, Serializer::UNSERIALIZE_METHOD_NATIVE);
        $serialized = Serializer::sleep($expectedUnserialized);
        $unserialized = Serializer::wake($serialized);

        static::assertEquals($expectedSerialized, $serialized);
        static::assertEquals($expectedUnserialized, $unserialized);
    }

    public function testSerializerClosure()
    {
        $serializerCallable = function ($toSerialize) {
            return igbinary_serialize($toSerialize);
        };
        $unSerializerCallable = function ($toUnSerialize) {
            return igbinary_unserialize($toUnSerialize);
        };

        $expectedUnserialized = [1, 'something', ['2, 3', 4]];
        $expectedSerialized = $serializerCallable($expectedUnserialized);

        Serializer::setSerializer($serializerCallable, $unSerializerCallable);
        $serialized = Serializer::sleep($expectedUnserialized);
        $unserialized = Serializer::wake($serialized);

        static::assertEquals($expectedSerialized, $serialized);
        static::assertEquals($expectedUnserialized, $unserialized);
    }

    public function testSerializerCallable()
    {
        $serializerCallable = [$this, 'serializerMethod'];
        $unSerializerCallable = [$this, 'unSerializerMethod'];

        $expectedUnserialized = [1, 'something', ['2, 3', 4]];
        $expectedSerialized = $this->serializerMethod($expectedUnserialized);

        Serializer::setSerializer($serializerCallable, $unSerializerCallable);
        $serialized = Serializer::sleep($expectedUnserialized);
        $unserialized = Serializer::wake($serialized);

        static::assertEquals($expectedSerialized, $serialized);
        static::assertEquals($expectedUnserialized, $unserialized);
    }

    public function serializerMethod($toSerialize)
    {
        return igbinary_serialize($toSerialize);
    }

    public function unSerializerMethod($toUnSerialize)
    {
        return igbinary_unserialize($toUnSerialize);
    }
}

/* EOF */
