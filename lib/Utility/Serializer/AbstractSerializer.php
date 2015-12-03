<?php

/*
 * This file is part of the scribe/wonka-bundle.
 *
 * (c) Scribe Inc. <rmf@scr.be>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\Wonka\Utility\Serializer;

use Scribe\Wonka\Utility\Caller\Call;

/**
 * Class AbstractSerializer.
 */
abstract class AbstractSerializer implements SerializerInterface
{
    /**
     * @var string|array|\Closure
     */
    protected static $serializerCallable = self::SERIALIZE_METHOD_DEFAULT;

    /**
     * @var string|array|\Closure
     */
    protected static $unSerializerCallable = self::UNSERIALIZE_METHOD_DEFAULT;

    /**
     * Perform serialization.
     *
     * @param mixed                      $valueToSerialize
     * @param string|array|\Closure|null $serializer
     *
     * @return mixed
     */
    public static function sleep($valueToSerialize, $serializer = null)
    {
        return Call::generic(self::determineSerializer(self::$serializerCallable, $serializer), $valueToSerialize);
    }

    /**
     * Perform unserialization.
     *
     * @param mixed                      $valueToUnSerialize
     * @param string|array|\Closure|null $unSerializer
     *
     * @return mixed
     */
    public static function wake($valueToUnSerialize, $unSerializer = null)
    {
        return Call::generic(self::determineSerializer(self::$unSerializerCallable, $unSerializer), $valueToUnSerialize);
    }

    /**
     * @param string|array|\Closure|null $serializer
     *
     * @return array|\Closure|null|string
     */
    protected static function determineSerializer($default, $serializer = null)
    {
        return $serializer === null ? $default : $serializer;
    }

    /**
     * @param string|array|\Closure      $serializer
     * @param string|array|\Closure|null $unSerializer
     */
    public static function setSerializer($serializer = self::SERIALIZE_METHOD_DEFAULT, $unSerializer = self::UNSERIALIZE_METHOD_DEFAULT)
    {
        self::$serializerCallable = $serializer;
        self::$unSerializerCallable = $unSerializer;
    }
}
