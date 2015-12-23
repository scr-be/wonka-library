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
 * Interface SerializerFactoryInterface.
 */
interface SerializerFactoryInterface
{
    /**
     * @return SerializerInterface
     */
    public static function create();
}

/* EOF */
