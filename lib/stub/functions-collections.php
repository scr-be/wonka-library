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

        $firstEl = array_shift($comparisons);
        $compare = function ($element) use ($firstEl) {
            if ($element !== $firstEl) {
                throw new \Exception('Not equals.');
            }
        };

        try {
            array_walk($comparisons, $compare);
        } catch (\Exception $exception) {
            return false;
        }

        return true;
    }

    /**
     * @param array|\ArrayAccess|\Countable|mixed $array
     *
     * @return bool
     */
    function supportsIterable($array)
    {
        return (bool) (is_array($array) || supportsArrayAccess($array) || supportsCountable($array));
    }

    /**
     * @param mixed $array
     *
     * @return bool
     */
    function supportsCountable($array)
    {
        return (bool) (is_array($array) || $array instanceof \Countable);
    }

    /**
     * @param mixed $array
     *
     * @return bool
     */
    function supportsArrayAccess($array)
    {
        if (is_array($array) || $array instanceof \ArrayAccess) {
            return true;
        }

        return false;
    }

    /**
     * @param mixed $iterable
     *
     * @return bool
     */
    function isEmptyIterable($iterable)
    {
        if (!supportsIterable($iterable)) {
            return;
        }

        return (bool) (!notEmptyIterable($iterable));
    }

    /**
     * @param mixed $iterable
     *
     * @return bool
     */
    function notEmptyIterable($iterable)
    {
        if (!supportsIterable($iterable)) {
            return;
        }

        return (bool) (getCountableSize($iterable) !== 0);
    }

    /**
     * @param mixed $array
     *
     * @return int
     */
    function getCountableSize($array)
    {
        return (int) (supportsCountable($array) ? count($array) : 0);
    }

    /**
     * @param string             $index
     * @param array|\ArrayAccess $array
     *
     * @return mixed|null
     */
    function getArrayElement($index, $array)
    {
        if (!supportsArrayAccess($array) || !array_key_exists($index, $array)) {
            return;
        }

        return $array[$index];
    }

    /**
     * @param array|\ArrayAccess $array
     *
     * @return mixed
     */
    function getFirstArrayElement($array)
    {
        if (!supportsArrayAccess($array)) {
            return;
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
        if (!supportsArrayAccess($array)) {
            return;
        }

        $element = end($array);

        return $element ?: null;
    }
}

/* EOF */
