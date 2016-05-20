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

namespace SR\Wonka\Utility\System\Platform;

use SR\Wonka\Utility\StaticClass\StaticClassTrait;

/**
 * Class Platform.
 */
class Platform
{
    use StaticClassTrait;

    /**
     * Response for Darwin (OSX) based OS.
     *
     * @var string
     */
    const TYPE_DARWIN = 'DAR';

    /**
     * Response string for Linux-based OS.
     *
     * @var string
     */
    const TYPE_LINUX = 'LIN';

    /**
     * Response for Windows-based OS.
     *
     * @var string
     */
    const TYPE_WINDOWS = 'WIN';

    /**
     * Response for unknown OS.
     *
     * @var null
     */
    const TYPE_UNKNOWN = null;

    /**
     * @return string
     */
    public static function name()
    {
        return static::normalizeName(PHP_OS);
    }

    /**
     * @param string $name
     *
     * @return bool
     */
    public static function is($name)
    {
        return static::equal(static::name(), $name);
    }

    /**
     * @param string $name
     *
     * @return bool
     */
    public static function isNot($name)
    {
        return !static::is($name);
    }

    /**
     * @param string $expected
     * @param string $name
     *
     * @return bool
     */
    public static function equal($expected, $name)
    {
        return static::normalizeName($expected) === static::normalizeName($name);
    }

    /**
     * @param string $name
     *
     * @return string
     */
    protected static function normalizeName($name)
    {
        return strtoupper(substr((string) $name, 0, 3));
    }
}

/* EOF */
