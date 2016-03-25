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

namespace SR\Wonka\Serializer;

use SR\Wonka\Utility\Extension;
use SR\Wonka\Utility\StaticClass\StaticClassTrait;

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
     * @param string $type
     *
     * @return SerializerInterface
     */
    public static function create($type = self::SERIALIZER_AUTO)
    {
        if ($type === self::SERIALIZER_AUTO && Extension::hasIgbinary()) {
            $type = self::SERIALIZER_IGBINARY;
        }

        return self::createRequestedType($type);
    }

    /**
     * @param string $type
     *
     * @return SerializerInterface
     */
    protected static function createRequestedType($type)
    {
        switch ($type) {
            case self::SERIALIZER_IGBINARY:
                return SerializerIgbinary::create();

            case self::SERIALIZER_JSON:
                return SerializerJson::create();
        }

        return SerializerNative::create();
    }
}

/* EOF */
