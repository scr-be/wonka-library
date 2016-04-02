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

namespace SR\Wonka\Tests\Utility\Serializer;

use SR\Wonka\Utility\UnitTest\WonkaTestCase;
use SR\Wonka\Utility\Serializer\Serializer;

class SerializerTest extends WonkaTestCase
{
    public function testThrowsExceptionOnInstantiation()
    {
        $this->setExpectedException(
            'SR\Exception\RuntimeException',
            'Cannot instantiate static class SR\Wonka\Utility\Serializer\Serializer'
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
