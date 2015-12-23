<?php

/*
 * This file is part of the Wonka Library.
 *
 * (c) Scribe Inc.     <oss@src.run>
 * (c) Rob Frawley 2nd <rmf@src.run>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\Wonka\Exception;

/**
 * Class RuntimeException.
 */
class RuntimeException extends \RuntimeException implements ExceptionInterface
{
    use ExceptionTrait;

    /**
     * @return string
     */
    public function getDefaultMessage()
    {
        return self::MSG_GENERIC;
    }

    /**
     * @return int
     */
    public function getDefaultCode()
    {
        return self::CODE_GENERIC;
    }
}

/* EOF */
