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

namespace Scribe\Wonka\Utility\Logger;

use Psr\Log\LogLevel;

/**
 * Interface LevelsAwareInterface.
 */
interface LevelsAwareInterface
{
    const EMERGENCY    = LogLevel::EMERGENCY;
    const ALERT        = LogLevel::ALERT;
    const CRITICAL     = LogLevel::CRITICAL;
    const ERROR        = LogLevel::ERROR;
    const WARNING      = LogLevel::WARNING;
    const NOTICE       = LogLevel::NOTICE;
    const INFO         = LogLevel::INFO;
    const DEBUG        = LogLevel::DEBUG;
    const HARD_DEFAULT = self::INFO;

    /**
     * @param string $level
     */
    public function setLevelDefault($level);

    /**
     * @return string
     */
    public function getLevelDefault();

    /**
     * @return string[]
     */
    public function getLevelListing();
}

/* EOF */
