<?php

/*
 * This file is part of the Wonka Bundle.
 *
 * (c) Scribe Inc.     <oss@src.run>
 * (c) Rob Frawley 2nd <rmf@src.run>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\Wonka\Serializer;

/**
 * Interface SerializerInterface.
 */
interface SerializerInterface
{
    /**
     * @param mixed|null    $data
     * @param \Closure|null $visitor
     *
     * @return mixed
     */
    public function serializeData($data = null, \Closure $visitor = null);

    /**
     * @param mixed|null    $data
     * @param \Closure|null $visitor
     *
     * @return mixed
     */
    public function unSerializeData($data = null, \Closure $visitor = null);
}

/* EOF */
