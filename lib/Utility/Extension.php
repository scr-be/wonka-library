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

namespace SR\Wonka\Utility;

use SR\Wonka\Exception\RuntimeException;
use SR\Wonka\Utility\StaticClass\StaticClassTrait;

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
            throw new RuntimeException('Cannot check extension availability against empty string in %s.', __CLASS__);
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
