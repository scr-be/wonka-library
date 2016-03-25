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

namespace SR\Wonka\Utility\Serializer;

/**
 * Class SerializerInterface.
 */
interface SerializerInterface
{
    /**
     * Serialize using igbinary.
     *
     * @var string
     */
    const SERIALIZE_METHOD_IGBINARY = 'igbinary_serialize';

    /**
     * Un-Serialize using igbinary.
     *
     * @var string
     */
    const UNSERIALIZE_METHOD_IGBINARY = 'igbinary_unserialize';

    /**
     * Serialize using json.
     *
     * @var string
     */
    const SERIALIZE_METHOD_JSON = 'json_encode';

    /**
     * Un-Serialize using json.
     *
     * @var string
     */
    const UNSERIALIZE_METHOD_JSON = 'json_decode';

    /**
     * Serialize using native PHP.
     *
     * @var string
     */
    const SERIALIZE_METHOD_NATIVE = 'serialize';

    /**
     * Un-Serialize using native PHP.
     *
     * @var string
     */
    const UNSERIALIZE_METHOD_NATIVE = 'unserialize';

    /**
     * Serialize default.
     *
     * @var string
     */
    const SERIALIZE_METHOD_DEFAULT = self::SERIALIZE_METHOD_IGBINARY;

    /**
     * Un-Serialize default.
     *
     * @var string
     */
    const UNSERIALIZE_METHOD_DEFAULT = self::UNSERIALIZE_METHOD_IGBINARY;

    /**
     * @param string|array|\Closure      $serializer
     * @param string|array|\Closure|null $unSerializer
     */
    public static function setSerializer($serializer, $unSerializer);
}

/* EOF */
