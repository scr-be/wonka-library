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

namespace Scribe\Wonka\Utility\Plode;

use Scribe\Wonka\Utility\StaticClass\StaticClassTrait;
use Scribe\Wonka\Utility\Caller\Call;
use Scribe\Wonka\Exception\BadFunctionCallException;

/**
 * Plode
 * Helper functions for common [ex/im]plode functionality.
 */
class Plode implements PlodeInterface
{
    /*
     * Trait to disallow class instantiation
     */
    use StaticClassTrait;

    /**
     * [Ex/Im]plode a [string/array] based on the separator specified in the
     * method name and the value passed as an argument.
     *
     * @param string $methodName Static method name called
     * @param mixed  $arguments  Static method arguments passed
     *
     * @return string|array
     */
    public static function __callStatic($methodName, $arguments)
    {
        if (strlen($methodName) <= 4 || count($arguments) !== 1) {
            self::__callStaticInvalid(
                'Expected method format is "[im|ex]OnSeparator" for example "imOnComma".'
            );
        }

        $plodeType = strtolower(substr($methodName, 0, 2));
        $plodeOn = strtolower(substr($methodName, 2, 2));
        $plodeSeparator = strtolower(substr($methodName, 4));
        $plodeValue = $arguments[0];
        $constantSeparator = __CLASS__.'::SEPARATOR_'.strtoupper($plodeSeparator);

        if ('im' !== $plodeType && 'ex' !== $plodeType) {
            self::__callStaticInvalid(
                'Valid method prefixes are "im" for "implode" and "ex" for "explode".'
            );
        } elseif ('on' !== $plodeOn) {
            self::__callStaticInvalid(
                sprintf(
                    'Expected method format is "[im|ex]OnSeparator" for example "imOnComma" but %s%s%s was provided.',
                    $plodeType,
                    ucwords($plodeOn),
                    ucwords($plodeSeparator)
                )
            );
        } elseif (false === defined($constantSeparator)) {
            self::__callStaticInvalid(
                sprintf('Invalid separator type of %s provided.', $plodeSeparator)
            );
        }

        return Call::staticMethod(__CLASS__, $plodeType, $plodeValue, constant($constantSeparator));
    }

    /**
     * Throws an exception on an invalid {@see __callStatic} call.
     *
     * @param string|null $message The message to be provided to the exception
     *
     * @throws BadFunctionCallException
     */
    public static function __callStaticInvalid($message = null)
    {
        $message = $message !== null ? $message : 'Invalid static magic call to %s';

        throw new BadFunctionCallException($message, __CLASS__);
    }

    /**
     * Implode array using default separator ({@see DEFAULT_SEPARATOR}).
     *
     * @param string[] $toImplode An array to implode into a string
     * @param string   $separator A string used to separate the imploded array values
     *
     * @return string
     */
    public static function im(array $toImplode, $separator = self::SEPARATOR_DEFAULT)
    {
        return (string) implode($separator, $toImplode);
    }

    /**
     * Explode string using default separator ({@see DEFAULT_SEPARATOR}).
     *
     * @param string $toExplode A value to explode into an array
     * @param string $separator The string used to separate the provided value
     *                          into an array
     *
     * @return array
     */
    public static function ex($toExplode, $separator = self::SEPARATOR_DEFAULT)
    {
        return (array) explode($separator, $toExplode);
    }
}

/* EOF */

/* EOF */
