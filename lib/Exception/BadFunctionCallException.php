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

use Scribe\Wonka\Exception\ExceptionInterface;
use Scribe\Wonka\Exception\ExceptionTrait;

/**
 * Class BadFunctionCallException.
 */
class BadFunctionCallException extends \BadFunctionCallException implements ExceptionInterface
{
    use ExceptionTrait;

    /**
     * An enhanced constructor that allows for passing the default \Exception parameters, as well as an array of additional
     * attributes followed by any number of additional arguments that will be passed to sprintf against the message.
     *
     * @param string|null  $message    An error message string (optionally fed to sprintf if optional args are given)
     * @param int|null     $code       The error code (which should be from ORMExceptionInterface). If null, the value
     *                                 of ExceptionInterface::CODE_GENERIC will be used.
     * @param mixed        $previous   The previous exception (when re-thrown within another exception), if applicable.
     * @param mixed[]|null $attributes An optional array of attributes to pass. Will be provided in the debug output.
     * @param mixed        ...$sprintfArgs Optional additional parameters that will be passed to sprintf against the
     *                                 message string provided.
     */
    public function __construct($message = null, $code = null, $previous = null, array $attributes = null, ...$sprintfArgs)
    {
        parent::__construct(
            $this->getFinalMessage((string) $message, ...$sprintfArgs),
            $this->getFinalCode((int) $code),
            $this->getFinalPreviousException($previous)
        );

        $this->setAttributes((array) $attributes);
    }

    /**
     * Get the default exception message.
     *
     * @return string
     */
    public function getDefaultMessage()
    {
        return self::MSG_GENERIC;
    }

    /**
     * Get the default exception code.
     *
     * @return int
     */
    public function getDefaultCode()
    {
        return self::CODE_GENERIC;
    }
}

/* EOF */
