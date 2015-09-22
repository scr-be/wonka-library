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
 * Class LogicException.
 */
class LogicException extends \LogicException implements ExceptionInterface
{
    use ExceptionTrait;

    /**
     * @param string|null  $message        An error message string (optionally fed to sprintf if optional args are given)
     * @param int|null     $code           The error code (which should be from ORMExceptionInterface). If null, the value
     *                                     of ExceptionInterface::CODE_GENERIC will be used.
     * @param mixed        $previous       The previous exception, if applicable.
     * @param mixed        $replaceSet,... All extra parameters passed are used to provide replacement values against the
     *                                     exception message.
     */
    public function __construct($message = null, $code = null, $previous = null, ...$replaceSet)
    {
        parent::__construct(
            $this->getFinalMessage((string) $message, ...$replaceSet),
            $this->getFinalCode((int) $code),
            $this->getFinalPreviousException($previous)
        );

        $this->setAttributes([]);
    }

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
