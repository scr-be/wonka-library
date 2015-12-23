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

namespace Scribe\Wonka\Utility\System\Platform;

use Scribe\Wonka\Utility\StaticClass\StaticClassTrait;

/**
 * Class SystemPlatform.
 */
class SystemPlatform
{
    use StaticClassTrait;

    /**
     * Response for Darwin (OSX) based OS.
     *
     * @var string
     */
    const OS_DARWIN = 'DAR';

    /**
     * Response string for Linux-based OS.
     *
     * @var string
     */
    const OS_LINUX = 'LIN';

    /**
     * Response for Windows-based OS.
     *
     * @var string
     */
    const OS_WINDOWS = 'WIN';

    /**
     * Response for unknown OS.
     *
     * @var null
     */
    const OS_UNKNOWN = null;

    /**
     * @return mixed
     */
    public static function getSystemPlatform()
    {
        return (string) static::normalizeSystemPlatform(PHP_OS);
    }

    /**
     * @param string $platform
     *
     * @return bool
     */
    public static function isSystemPlatform($platform)
    {
        return (bool) (static::getSystemPlatform() === static::normalizeSystemPlatform($platform) ?: false);
    }

    /**
     * @param mixed $platform
     *
     * @return bool
     */
    public static function isNotSystemPlatform($platform)
    {
        return (bool) (static::isSystemPlatform($platform) === false);
    }

    /**
     * @param string $name
     *
     * @return string
     */
    protected static function normalizeSystemPlatform($name)
    {
        return (string) (strtoupper(substr($name, 0, 3)));
    }
}

/* EOF */
