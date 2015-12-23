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

    use Scribe\Wonka\Utility\Error\DeprecationErrorHandler;

    /**
     * @codeCoverageIgnore
     *
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
     * @codeCoverageIgnore
     *
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
     * @codeCoverageIgnore
     *
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
     * @codeCoverageIgnore
     *
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
     * @codeCoverageIgnore
     *
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
     * @codeCoverageIgnore
     *
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
     * @codeCoverageIgnore
     *
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
     * @codeCoverageIgnore
     *
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
     * @codeCoverageIgnore
     *
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
     * @codeCoverageIgnore
     *
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
     * @codeCoverageIgnore
     *
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
     * @codeCoverageIgnore
     *
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
