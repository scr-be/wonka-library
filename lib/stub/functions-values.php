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

namespace {

    use Scribe\Wonka\Exception\InvalidArgumentException;

    /**
     * Checks for null or empty value.
     *
     * @param mixed $mixed
     *
     * @return bool
     */
    function isNullOrEmpty($mixed)
    {
        return (bool) ($mixed === null || empty($mixed) === true);
    }

    /**
     * @param mixed $value
     *
     * @return bool
     */
    function notNullOrEmpty($value)
    {
        return (bool) (!isNullOrEmpty($value));
    }

    /**
     * @param string $string
     *
     * @return bool
     */
    function isNullOrEmptyStr($string)
    {
        if (!is_string($string)) {
            throw new InvalidArgumentException('Value provided to %s is not a sting.', null, null, __FUNCTION__);
        }

        return (bool) ($string === null || mb_strlen($string) === 0);
    }

    /**
     * @param $string
     *
     * @return bool
     */
    function notNullOrEmptyStr($string)
    {
        return (bool) (!isNullOrEmptyStr($string));
    }
}

/* EOF */
