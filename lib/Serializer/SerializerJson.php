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
 * Class SerializerJson.
 */
class SerializerJson implements SerializerInterface
{
    /**
     * @param mixed $data
     *
     * @return string
     */
    public function getSerialized($data)
    {
        return json_encode($data);
    }

    /**
     * @param mixed $data
     *
     * @return mixed
     */
    public function getUnSerialized($data)
    {
        return json_decode($data);
    }
}

/* EOF */
