<?php

/*
 * This file is part of the Wonka Bundle.
 *
 * (c) Scribe Inc. <rmf@scr.be>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\Wonka\Serializer;

use Scribe\Wonka\Utility\Extension;
use Scribe\Wonka\Utility\StaticClass\StaticClassTrait;

/**
 * Class SerializerFactory.
 */
class SerializerFactory implements SerializerFactoryInterface
{
    use StaticClassTrait;

    /**
     * @var string
     */
    const SERIALIZER_AUTO = 'auto';

    /**
     * @var string
     */
    const SERIALIZER_NATIVE = 'native';

    /**
     * @var string
     */
    const SERIALIZER_IGBINARY = 'igbinary';

    /**
     * @var string
     */
    const SERIALIZER_JSON = 'json';

    /**
     * @param string $serializer
     *
     * @return SerializerInterface
     */
    public static function create($serializer = self::SERIALIZER_AUTO)
    {
        if ($serializer === self::SERIALIZER_AUTO && Extension::hasIgbinary()) {
            return new SerializerIgbinary();
        }

        switch ($serializer) {
            case self::SERIALIZER_IGBINARY:
                return new SerializerIgbinary();

            case self::SERIALIZER_JSON:
                return new SerializerJson();

            case self::SERIALIZER_NATIVE:
            case self::SERIALIZER_AUTO:
            default:
                return new SerializerNative();
        }
    }
}

/* EOF */
