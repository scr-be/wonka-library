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

namespace SR\Wonka\Utility\Logger;

/**
 * Class LevelsAwareTrait.
 */
trait LevelsAwareTrait
{
    /**
     * @var string
     */
    protected $levelDefault;

    /**
     * @param string $level
     */
    public function setLevelDefault($level)
    {
        $this->levelDefault = $this->getLevelValidated($level);
    }

    /**
     * @return string
     */
    public function getLevelDefault()
    {
        return $this->getLevelValidated($this->levelDefault);
    }

    /**
     * @return string[]
     */
    public function getLevelListing()
    {
        return [
            LevelsAwareInterface::EMERGENCY,
            LevelsAwareInterface::ALERT,
            LevelsAwareInterface::CRITICAL,
            LevelsAwareInterface::ERROR,
            LevelsAwareInterface::WARNING,
            LevelsAwareInterface::NOTICE,
            LevelsAwareInterface::INFO,
            LevelsAwareInterface::DEBUG,
        ];
    }

    /**
     * @param null|string $level
     *
     * @return string
     */
    protected function getLevelValidated($level = null)
    {
        return in_array($level, $this->getLevelListing()) ? $level : LevelsAwareInterface::HARD_DEFAULT;
    }
}

/* EOF */
