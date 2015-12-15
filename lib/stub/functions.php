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

    /**
     * @param string      $application
     * @param string|null $framework
     *
     * @return bool
     */
    function extensionEnableNewRelic($application, $framework = null)
    {
        if (!extension_loaded('newrelic') || !function_exists('newrelic_set_appname')) {
            return false;
        }

        newrelic_set_appname($application);

        if (notNullOrEmpty($framework)) {
            ini_set('newrelic.framework', $framework);
        }

        return true;
    }

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
