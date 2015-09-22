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
 * Class Extension.
 */
class Extension
{
    /*
     * Trait to disallow class instantiation
     */
    use StaticClassTrait;

    /**
     * Check if an extension is loaded or not.
     *
     * @param string $extension
     *
     * @return bool
     */
    public static function isEnabled($extension)
    {
        if (empty((string) $extension)) {
            throw new RuntimeException('Cannot check extension availability against empty string in %s.', null, null, __CLASS__);
        }

        return (bool) (true === extension_loaded((string) $extension));
    }

    /**
     * @param string[] ...$extensionCollection
     *
     * @return bool|string
     */
    public static function areAnyEnabled(...$extensionCollection)
    {
        foreach ($extensionCollection as $extension) {
            if (true === self::isEnabled($extension)) {
                return $extension;
            }
        }

        return false;
    }

    /**
     * @param string[] ...$extensionCollection
     *
     * @return bool
     */
    public static function areAllEnabled(...$extensionCollection)
    {
        foreach ($extensionCollection as $extension) {
            if (false === self::isEnabled($extension)) {
                return false;
            }
        }

        return true;
    }

    /**
     * Check if igbinary is enabled.
     *
     * @return bool
     */
    public static function hasIgbinary()
    {
        return self::isEnabled('igbinary');
    }

    /**
     * Check if json is enabled.
     *
     * @return bool
     */
    public static function hasJson()
    {
        return self::isEnabled('json');
    }
}

/* EOF */
