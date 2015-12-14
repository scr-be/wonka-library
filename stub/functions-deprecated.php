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

    use Scribe\Wonka\Utility\Error\DeprecationErrorHandler;

    /**
     * @deprecated
     *
     * @param mixed,... $comparisonSet
     *
     * @throws \RuntimeException
     *
     * @return bool
     */
    function compare_strict(...$comparisonSet)
    {
        DeprecationErrorHandler::trigger(__FUNCTION__, __LINE__,
            'Use "isCollectionEquals" instead.', '2015-12-14 09:00 -0400', '0.3');

        return isCollectionEquals(...$comparisonSet);
    }

    /**
     * @deprecated
     *
     * @param array|\ArrayAccess|\Countable|mixed $iterable
     *
     * @return bool
     */
    function is_iterable($iterable)
    {
        DeprecationErrorHandler::trigger(__FUNCTION__, __LINE__,
            'Use "supportsIterable" instead.', '2015-12-14 09:00 -0400', '0.3');

        return supportsIterable($iterable);
    }

    /**
     * @deprecated
     *
     * @param mixed $iterable
     *
     * @return bool
     */
    function is_iterable_empty($iterable)
    {
        DeprecationErrorHandler::trigger(__FUNCTION__, __LINE__,
            'Use "isEmptyIterable" instead.', '2015-12-14 09:00 -0400', '0.3');

        return isEmptyIterable($iterable);
    }

    /**
     * @deprecated
     *
     * @param mixed $iterable
     *
     * @return bool
     */
    function is_iterable_not_empty($iterable)
    {
        DeprecationErrorHandler::trigger(__FUNCTION__, __LINE__,
            'Use "notEmptyIterable" instead.', '2015-12-14 09:00 -0400', '0.3');

        return notEmptyIterable($iterable);
    }

    /**
     * @deprecated
     *
     * @param mixed $iterable
     *
     * @return false|int
     */
    function get_iterable_count($iterable)
    {
        DeprecationErrorHandler::trigger(__FUNCTION__, __LINE__,
            'Use "getCountableSize" instead.', '2015-12-14 09:00 -0400', '0.3');

        return getCountableSize($iterable);
    }

    /**
     * @deprecated
     *
     * @param string $key
     * @param mixed  $iterable
     *
     * @return mixed|null
     */
    function get_iterable_value_by_key($key, $iterable)
    {
        DeprecationErrorHandler::trigger(__FUNCTION__, __LINE__,
            'Use "getArrayElement" instead.', '2015-12-14 09:00 -0400', '0.3');

        return getArrayElement($key, $iterable);
    }

    /**
     * @deprecated
     *
     * @param array $array
     *
     * @return mixed
     */
    function array_first(array $array = [])
    {
        DeprecationErrorHandler::trigger(__FUNCTION__, __LINE__,
            'Use "getFirstArrayElement" instead.', '2015-12-14 09:00 -0400', '0.3');

        return getFirstArrayElement($array);
    }

    /**
     * @deprecated
     *
     * @param array $array
     *
     * @return mixed
     */
    function array_last(array $array = [])
    {
        DeprecationErrorHandler::trigger(__FUNCTION__, __LINE__,
            'Use "getLastArrayElement" instead.', '2015-12-14 09:00 -0400', '0.3');

        return getLastArrayElement($array);
    }

    /**
     * @deprecated
     *
     * @param string      $application
     * @param string|null $framework
     *
     * @return bool
     */
    function enable_new_relic_extension($application, $framework = null)
    {
        DeprecationErrorHandler::trigger(__FUNCTION__, __LINE__,
            'Use "enableNewRelicExtension" instead.', '2015-12-14 09:00 -0400', '0.3');

        return extensionEnableNewRelic($application, $framework);
    }

    /**
     * @deprecated
     *
     * @param string $string
     *
     * @return bool
     */
    function is_null_or_empty_string($string)
    {
        DeprecationErrorHandler::trigger(__FUNCTION__, __LINE__,
            'Use "isNullOrEmptyStr" instead.', '2015-12-14 09:00 -0400', '0.3');

        return isNullOrEmptyStr($string);
    }

    /**
     * @deprecated
     *
     * @param $string
     *
     * @return bool
     */
    function not_null_or_empty_string($string)
    {
        DeprecationErrorHandler::trigger(__FUNCTION__, __LINE__,
            'Use "notNullOrEmptyStr" instead.', '2015-12-14 09:00 -0400', '0.3');

        return notNullOrEmptyStr($string);
    }

    /**
     * @deprecated
     *
     * @param mixed $value
     *
     * @return bool
     */
    function is_null_or_empty($value)
    {
        DeprecationErrorHandler::trigger(__FUNCTION__, __LINE__,
            'Use "nullOrEmpty" instead.', '2015-12-14 09:00 -0400', '0.3');

        return isNullOrEmpty($value);
    }
}

/* EOF */
