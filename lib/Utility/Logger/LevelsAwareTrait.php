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

use SR\Reflection\Inspect;
use SR\Reflection\Inspector\ConstantInspector;

/**
 * Class LevelsAwareTrait.
 */
trait LevelsAwareTrait
{
    /**
     * @var string
     */
    private $logLevelDefault = self::LOG_LEVEL_DEFAULT;

    /**
     * @param string|null $level
     */
    public function setLogDefaultLevel($level = null)
    {
        $this->logLevelDefault = $this->sanitizeLogLevelConstant($level);
    }

    /**
     * @return string
     */
    public function getLogDefaultLevel() : string
    {
        return $this->logLevelDefault;
    }

    /**
     * @return bool
     */
    public function isLogDefaultLevel() : bool
    {
        return $this->logLevelDefault === self::LOG_LEVEL_DEFAULT;
    }

    /**
     * @return string[]
     */
    public function getLogLevels(): array
    {
        return $this->getLogLevelConstantValues();
    }

    /**
     * @param null|string $level
     *
     * @return string
     */
    private function sanitizeLogLevelConstant($level = null)
    {
        $levelOpening = 'LOG_LEVEL_';
        $levelDefault = $levelOpening.'DEFAULT';

        $level = strtoupper($level);

        if (substr($level, 0, 10) !== $levelOpening) {
            $level = $levelOpening.$level;
        }

        if (!in_array($level, $this->getLogLevelConstantNames())) {
            $level = $levelDefault;
        }

        return constant(__CLASS__.'::'.$level);
    }

    /**
     * @return \SR\Reflection\Inspector\ConstantInspector[]
     */
    private function getLogLevelConstants()
    {
        return Inspect::useInstance($this)->constants();
    }

    /**
     * @return string[]
     */
    private function getLogLevelConstantNames()
    {
        return array_map(function (ConstantInspector $constant) {
            return (string) $constant->name();
        }, $this->getLogLevelConstants());
    }

    /**
     * @return string[]
     */
    private function getLogLevelConstantValues()
    {
        return array_map(function (ConstantInspector $constant) {
            return (string) $constant->value();
        }, $this->getLogLevelConstants());
    }
}

/* EOF */
