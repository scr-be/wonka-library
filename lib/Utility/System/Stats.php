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

namespace Scribe\Wonka\Utility\System;

use Scribe\Wonka\Exception\LogicException;
use Scribe\Wonka\Exception\RuntimeException;
use Scribe\Wonka\Utility\Math;
use Scribe\Wonka\Utility\StaticClass\StaticClassTrait;
use Scribe\Wonka\Utility\System\Execute\Command;

/**
 * Class Stats.
 */
class Stats
{
    use StaticClassTrait;

    /**
     * @param int $precision
     *
     * @return int[]
     */
    public static function getLoadAverages($precision = 2)
    {
        $loadAveragesDirect = sys_getloadavg();

        $loadAverages[0] = time();
        $loadAverages[1] = round($loadAveragesDirect[0], $precision);
        $loadAverages[2] = round($loadAveragesDirect[1], $precision);
        $loadAverages[3] = round($loadAveragesDirect[2], $precision);
        $loadAverages[4] = round(array_sum($loadAveragesDirect) / 3, $precision);

        return (array) $loadAverages;
    }

    /**
     * @param int $precision
     *
     * @return int[]
     */
    public static function getLoadAveragesAsPercent($precision = 2)
    {
        $coreCount = static::getCoreCount();

        list($time, $load01, $load05, $load15, $loadAverage)
            = static::getLoadAverages($precision);

        return [
            $time,
            Math::toBase($load01, $coreCount, 100, true),
            Math::toBase($load05, $coreCount, 100, true),
            Math::toBase($load15, $coreCount, 100, true),
            Math::toBase($loadAverage, $coreCount, 100),
        ];
    }

    /**
     * @return int
     */
    public static function getCoreCount()
    {
        return (int) static::getCoreCountPlatformLookup();
    }

    /**
     * @return int
     */
    protected static function getCoreCountPlatformLookup()
    {
        if (Platform::isNot(Platform::TYPE_LINUX)) {
            throw new LogicException('Unsupported system platform type.');
        }

        $command = new Command();
        $outputs = $command
            ->start()
            ->setCommand('cat /proc/stat | grep cpu[0-9] | wc -l')
            ->run()
            ->getOutput();


        if (isNullOrEmpty($outputs) || !isCountableEqual($outputs, 1)) {
            throw new RuntimeException('The platform %s returned invalid core count lookup data with return "%d".', Platform::name(), (int) $command->getReturn());
        }

        return (int) array_shift($outputs);
    }
}

/* EOF */
