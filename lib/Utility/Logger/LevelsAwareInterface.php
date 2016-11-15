<?php

/*
 * This file is part of the `src-run/wonka-library` project.
 *
 * (c) Rob Frawley 2nd <rmf@src.run>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace SR\Wonka\Utility\Logger;

use Psr\Log\LogLevel;

/**
 * Interface LevelsAwareInterface.
 */
interface LevelsAwareInterface
{
    const LOG_LEVEL_EMERGENCY = LogLevel::EMERGENCY;
    const LOG_LEVEL_ALERT = LogLevel::ALERT;
    const LOG_LEVEL_CRITICAL = LogLevel::CRITICAL;
    const LOG_LEVEL_ERROR = LogLevel::ERROR;
    const LOG_LEVEL_WARNING = LogLevel::WARNING;
    const LOG_LEVEL_NOTICE = LogLevel::NOTICE;
    const LOG_LEVEL_INFO = LogLevel::INFO;
    const LOG_LEVEL_DEBUG = LogLevel::DEBUG;
    const LOG_LEVEL_DEFAULT = self::LOG_LEVEL_DEBUG;

    /**
     * @param string|null $level
     */
    public function setLogDefaultLevel($level = null);

    /**
     * @return string
     */
    public function getLogDefaultLevel() : string;
}

/* EOF */
