<?php

/*
 * This file is part of the scribe/wonka-bundle.
 *
 * (c) Scribe Inc. <rmf@scr.be>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\Wonka\Exception;

/**
 * Class Exception.
 */
class Exception extends \Exception implements ExceptionInterface
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
