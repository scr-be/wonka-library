<?php

/*
 * This file is part of the `src-run/wonka-library` project.
 *
 * (c) Rob Frawley 2nd <rmf@src.run>
 * (c) Scribe Inc      <scr@src.run>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace {

    use SR\Exception\InvalidArgumentException;

    /**
     * @param mixed $first
     * @param mixed $second
     *
     * @return bool
     */
    function isEqual($first, $second)
    {
        return isCollectionEquals($first, $second);
    }

    /**
     * @param mixed,... $comparisons
     *
     * @throws \RuntimeException
     *
     * @return bool
     */
    function isCollectionEquals(...$comparisons)
    {
        if (!is_array($comparisons) || count($comparisons) < 2) {
            throw new InvalidArgumentException('You must provide at least two items to compare their equality.');
        }

        $expected = array_shift($comparisons);

        foreach ($comparisons as $c) {
            if ($expected !== $c) return false;
        }

        return true;
    }

    /**
     * @param array|\ArrayAccess|\Countable|mixed $array
     *
     * @return bool
     */
    function isIterable($what)
    {
        return (isArray($what) || hasArrayAccess($what) || isCountable($what)) === true;
    }

    /**
     * @param mixed $what
     *
     * @return bool
     */
    function isCountable($what)
    {
        return (isArray($what) || ($what instanceof \Countable)) === true;
    }

    /**
     * @param mixed $what
     *
     * @return bool
     */
    function hasArrayAccess($what)
    {
        return (isArray($what) || ($what instanceof \ArrayAccess)) === true;
    }

    /**
     * @param mixed $array
     *
     * @return bool
     */
    function isArray($array)
    {
        return is_array($array);
    }

    /**
     * @param mixed $iterable
     *
     * @return bool
     */
    function isIterableEmpty($iterable)
    {
        return isCountable($iterable) ? isCountableEqual($iterable, 0) : null;
    }

    /**
     * @param mixed $iterable
     *
     * @return bool
     */
    function isIterableNotEmpty($iterable)
    {
        return isCountable($iterable) ? (isCountableEqual($iterable, 0) !== true) : null;
    }

    /**
     * @param mixed $countable
     *
     * @return int|null
     */
    function countableSize($countable)
    {
        return isIterable($countable) ? count($countable) : null;
    }

    /**
     * @param \Countable|mixed[] $countable
     * @param int                $expected
     *
     * @return bool|null
     */
    function isCountableEqual($countable, $expected = 0)
    {
        if (($result = countableSize($countable)) === null) {
            return null;
        }

        return ($result === $expected);
    }

    /**
     * @param \Countable|mixed $countable
     *
     * @return bool|null
     */
    function isCountableEmpty($countable)
    {
        return isCountableEqual($countable, 0);
    }

    /**
     * @param string             $index
     * @param array|\ArrayAccess $array
     *
     * @return mixed|null
     */
    function getArrayElement($index, $array)
    {
        return (hasArrayAccess($array) && array_key_exists($index, $array)) ?
            $array[$index] : null;
    }

    /**
     * @param array|\ArrayAccess $array
     *
     * @return mixed
     */
    function getFirstArrayElement($array)
    {
        if (!hasArrayAccess($array)) {
            return null;
        }

        $element = reset($array);

        return $element ?: null;
    }

    /**
     * @param array|\ArrayAccess $array
     *
     * @return mixed
     */
    function getLastArrayElement($array)
    {
        if (!hasArrayAccess($array) || isCountableEmpty($array)) {
            return null;
        }

        $element = end($array);

        return $element ?: null;
    }
}

/* EOF */
