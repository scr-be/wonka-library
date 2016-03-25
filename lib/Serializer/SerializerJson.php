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

/**
 * Class SerializerJson.
 */
class SerializerJson extends AbstractSerializer
{
    /**
     * SerializerJson constructor.
     */
    public function __construct()
    {
        $this->serializationHandler = 'json_encode';
        $this->unSerializationHandler = 'json_decode';
    }
}

/* EOF */
