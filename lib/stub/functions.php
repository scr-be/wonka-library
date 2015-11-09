<?php

/*
 * This file is part of the scribe/wonka-bundle.
 *
 * (c) Scribe Inc. <rmf@scr.be>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace {

    /**
     * Variadic function that performs a strict comparison on all arguments passed to it and determines if they are
     * equal or not.
     *
     * @param mixed,... $comparisonSet
     *
     * @throws \RuntimeException
     *
     * @return bool
     */
    function compare_strict(...$comparisonSet)
    {
        if (false === is_iterable($comparisonSet) || true === is_iterable_empty($comparisonSet) || count($comparisonSet) < 2) {
            throw new \RuntimeException('You must provide at least two items to compare.');
        }

        $firstItem = array_shift($comparisonSet);

        try {
            array_walk($comparisonSet, function ($value) use ($firstItem) {
                if ($firstItem !== $value) { throw new \Exception; }
            });
        } catch (\Exception $e) {
            return false;
        }

        return true;
    }

    /**
     * Checks if the passed item is an iterable type: an array, or an object with support for
     * iteration: \Iterator, \ArrayAccess, \Countable, and Doctrin's ArrayCollection.
     *
     * @param array|\Iterator|\ArrayAccess|\Countable|ArrayCollection|mixed $iterable
     *
     * @return bool
     */
    function is_iterable($iterable)
    {
        return (bool) (
            true === is_array($iterable) ||
            true === ($iterable instanceof \ArrayAccess) ||
            true === ($iterable instanceof \Countable)
        );
    }

    /**
     * Checks if an iterable item is empty. {@see is_iterable_not_empty} for its inverse.
     *
     * @param mixed $iterable
     *
     * @return bool
     */
    function is_iterable_empty($iterable)
    {
        return (bool) !is_iterable_not_empty($iterable);
    }

    /**
     * Checks if an iterable item is not empty. {@see is_iterable_empty} for its inverse.
     *
     * @param mixed $iterable
     *
     * @return bool
     */
    function is_iterable_not_empty($iterable)
    {
        if (false === is_iterable($iterable)) {
            return false;
        }

        return (bool) (true === (count($iterable) > 0) ? true : false);
    }

    /**
     * Returns the count of an iterable item, or false if the item is not iterable.
     *
     * @param mixed $iterable
     *
     * @return false|int
     */
    function get_iterable_count($iterable)
    {
        return (int) (is_iterable($iterable) ? count($iterable) : 0);
    }

    /**
     * Get the value of an iterable item via its key.
     *
     * @param string $key
     * @param mixed $iterable
     *
     * @return null
     */
    function get_iterable_value_by_key($key, $iterable)
    {
        if (true !== is_iterable($iterable) || false === array_key_exists($key, $iterable)) { return null; }

        return $iterable[$key];
    }

    /**
     * Helper function to get first element of an array (works around the fact that PHP won't return a function/method
     * value by reference).
     *
     * @param array $array
     *
     * @return mixed
     */
    function array_first(array $array = [])
    {
        $arrayItem = reset($array);

        return ($arrayItem === false ? null : $arrayItem);
    }

    /**
     * Helper function to get last element of an array (works around the fact that PHP won't return a function/method
     * value by reference).
     *
     * @param array $array
     *
     * @return mixed
     */
    function array_last(array $array = [])
    {
        $arrayItem = end($array);

        return ($arrayItem === false ? null : $arrayItem);
    }

    /**
     * @param string      $application
     * @param string|null $framework
     *
     * @return bool
     */
    function enable_new_relic_extension($application, $framework = null)
    {
        if (false === extension_loaded('newrelic') ||
            false === function_exists('newrelic_set_appname')
        ) {
            return false;
        }

        newrelic_set_appname($application);

        if (null !== $framework) {
            ini_set('newrelic.framework', $framework);
        }

        return true;
    }

    /**
     * Checks for null or empty string.
     *
     * @param string $string
     *
     * @return bool
     */
    function is_null_or_empty_string($string)
    {
        return (bool) ($string === null || strlen((string) $string) === 0);
    }

    /**
     * Checks for null or empty value.
     *
     * @param mixed $value
     *
     * @return bool
     */
    function is_null_or_empty($value)
    {
        return (bool) ($value === null || true === empty($value));
    }
}

/* EOF */
