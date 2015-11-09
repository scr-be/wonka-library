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

/**
 * Class SerializerIgbinary.
 */
final class SerializerIgbinary extends AbstractSerializer
{
    /**
     * SerializerIgbinary constructor.
     */
    public function __construct()
    {
        $this->serializationHandler = 'igbinary_serialize';
        $this->unSerializationHandler = 'igbinary_unserialize';
    }
}

/* EOF */
