<?php

/*
 * This file is part of the scribe/wonka-bundle.
 *
 * (c) Scribe Inc. <rmf@scr.be>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\Wonka\Exception\Model;

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
    const MSG_GENERIC = 'An undefined exception was thrown.';

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
     * Generic exception code for exceptions thrown from within Mantle library.
     *
     * @var int
     */
    const CODE_GENERIC_FROM_MANTLE_LIB = 1000;

    /**
     * Generic exception code for exceptions thrown from within Mantle bundle.
     *
     * @var int
     */
    const CODE_GENERIC_FROM_MANTLE_BDL = 2000;

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
    public function __construct($message = null, $code = null, $previous = null, array $attributes = null, ...$sprintfArgs);

    /**
     * Get an instance of the exception, allowing for setting the message and any substitution parameters.
     *
     * @param string|null $message
     * @param mixed       ...$sprintfArgs
     *
     * @return $this
     */
    public static function getInstance($message, ...$sprintfArgs);

    /**
     * Get an instance of the exception, allowing for providing only string substitution parameters.
     *
     * @param mixed ...$sprintfArgs
     *
     * @return $this
     */
    public static function getDefaultInstance(...$sprintfArgs);

    /**
     * Output string representation of exception with general, entity, and trace included.
     *
     * @return string
     */
    public function __toString();

    /**
     * Validate message by providing a default if one was not provided and optionally calling sprintf on the message
     * if arguments were passed for string replacement.
     *
     * @param null|string $message
     * @param mixed       ...$sprintfArgs
     *
     * @internal
     *
     * @return string
     */
    public function getFinalMessage($message = null, ...$sprintfArgs);

    /**
     * Validate code by providing a default if one was not provided.
     *
     * @param int|null $code
     *
     * @internal
     *
     * @return int
     */
    public function getFinalCode($code = null);

    /**
     * Validate previous exception by requiring it is a subclass of \Exception or returning null.
     *
     * @param mixed $exception
     *
     * @internal
     *
     * @return null|\Exception
     */
    public function getFinalPreviousException($exception = null);

    /**
     * Get the default exception message.
     *
     * @return string
     */
    public function getDefaultMessage();

    /**
     * Get the default exception code.
     *
     * @return int
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
     * Returns the attributes array.
     *
     * @return array
     */
    public function getAttributes();

    /**
     * Returns the exception information (with all debug information) as an array.
     *
     * @return array
     */
    public function getDebugOutput();

    /**
     * Get trace limited to only one object-level of depth.
     *
     * @return array
     */
    public function getTraceLimited();

    /**
     * Get the exception type (class name).
     *
     * @return string
     */
    public function getType();

    /**
     * Get the exception namespace (class namespace).
     *
     * @return string
     */
    public function getTypeNamespace();
}

/* EOF */
