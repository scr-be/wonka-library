<?php

/*
 * This file is part of the scribe/wonka-bundle.
 *
 * (c) Scribe Inc. <rmf@scr.be>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\Wonka\Utility;

use Scribe\Wonka\Exception\RuntimeException;
use Scribe\Wonka\Utility\StaticClass\StaticClassTrait;

/**
 * Class Arrays.
 */
class Arrays
{
    /*
     * Trait to disallow class instantiation
     */
    use StaticClassTrait;

    /**
     * Determines if the given array is a "hash" (associative) array or indexed
     * by integer array. This only works if the indexed array consists of
     * consecutive integers, otherwise it will mis-represent such an array as hash.
     *
     * @param array $array An array to check against
     * @param bool  $throw Should an exception be thrown or the inconsistency
     *                     ignored?
     *
     * @return bool
     *
     * @throws RuntimeException
     */
    public static function isHash(array $array, $throw = true)
    {
        if (true === (count($array) === 0) && true === $throw) {
            throw new RuntimeException(
                'There is no way to determine if en empty array is a hash or not.'
            );
        }

        $keys = array_keys($array);

        return (bool) (array_keys($keys) !== $keys);
    }
}

/* EOF */

/* EOF */
