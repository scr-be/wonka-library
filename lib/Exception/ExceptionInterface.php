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
 * Interface ExceptionInterface.
 */
interface ExceptionInterface
{
    /**
     * Generic exception message. Should be avoided.
     *
     * @var string
     */
    const MSG_GENERIC = 'An undefined exception was thrown. %s';

    /**
     * Exception code for an unknown/undefined state.
     *
     * @var int
     */
    const CODE_UNKNOWN = -10;

    /**
     * Generic exception code for...absolutely generic, unspecified exceptions.
     *
     * @var int
     */
    const CODE_GENERIC = -5;

    /**
     * Generic exception code for exceptions thrown from within Wonka library.
     *
     * @var int
     */
    const CODE_GENERIC_FROM_LIBRARY = 1000;

    /**
     * Generic exception code for exceptions thrown from within Wonka bundle.
     *
     * @var int
     */
    const CODE_GENERIC_FROM_BUNDLE = 2000;

    /**
     * Exception code for generic invalid arguments exception.
     *
     * @var int
     */
    const CODE_INVALID_ARGS = 50;

    /**
     * Exception code for an invalid style being passed by user.
     *
     * @var int
     */
    const CODE_INVALID_STYLE = 51;

    /**
     * Exception code for generic missing arguments.
     *
     * @var int
     */
    const CODE_MISSING_ARGS = 100;

    /**
     * Exception code for a missing entity.
     *
     * @var int
     */
    const CODE_MISSING_ENTITY = 101;

    /**
     * Exception code for an unknown/missing service.
     *
     * @var int
     */
    const CODE_MISSING_SERVICE = 201;

    /**
     * Exception code for an inconsistent fixture data error.
     *
     * @var int
     */
    const CODE_FIXTURE_DATA_INCONSISTENT = 735;

    /**
     * @param string|null  $message        An error message string (optionally fed to sprintf if optional args are given)
     * @param int|null     $code           The error code (which should be from ORMExceptionInterface). If null, the value
     *                                     of ExceptionInterface::CODE_GENERIC will be used.
     * @param mixed        $previous       The previous exception, if applicable.
     * @param mixed        $replaceSet,... All extra parameters passed are used to provide replacement values against the
     *                                     exception message.
     */
    public function __construct($message = null, $code = null, $previous = null, ...$replaceSet);

    /**
     * @return string
     */
    public function __toString();

    /**
     * @param null|string $message
     * @param mixed,...   $replaceSet
     *
     * @internal
     *
     * @return string
     */
    public function getFinalMessage($message = null, ...$replaceSet);

    /**
     * @param int|null $code
     *
     * @internal
     *
     * @return int
     */
    public function getFinalCode($code = null);

    /**
     * @param mixed $exception
     *
     * @internal
     *
     * @return null|\Exception
     */
    public function getFinalPreviousException($exception = null);

    /**
     * @return string
     */
    public function getDefaultMessage();

    /**@return int
     */
    public function getDefaultCode();

    /**
     * @param array $attributes
     *
     * @return $this
     */
    public function setAttributes(array $attributes = []);

    /**
     * @param mixed       $attribute
     * @param null|string $key
     *
     * @return $this
     */
    public function addAttribute($attribute, $key = null);

    /**
     * @return array
     */
    public function getAttributes();

    /**
     * @return array
     */
    public function getDebugOutput();

    /**
     * @return array
     */
    public function getTraceLimited();

    /**
     * @return string
     */
    public function getType();
}

/* EOF */
