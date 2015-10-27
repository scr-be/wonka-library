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
