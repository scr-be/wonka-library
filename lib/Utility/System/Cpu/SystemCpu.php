<?php

/*
 * This file is part of the scribe/wonka-bundle.
 *
 * (c) Scribe Inc. <rmf@scr.be>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\Wonka\Utility\System\Cpu;

use Scribe\CacheBundle\DependencyInjection\Aware\CacheChainAwareTrait;
use Scribe\Wonka\Exception\RuntimeException;
use Scribe\Wonka\Utility\Math;
use Scribe\Wonka\Utility\System\Execute\SystemExecute;
use Scribe\Wonka\Utility\System\Platform\SystemPlatform;

/**
 * Class SystemCpu.
 */
class SystemCpu
{
    use CacheChainAwareTrait;

    /**
     * @param int $precision
     *
     * @return int[]
     */
    public function getLoadAverages($precision = 2)
    {
        $this->getCacheChain()->setTtl(60);

        if (null !== ($loadAverages = $this->getCacheChain()->get(__METHOD__))) {
            $loadAveragesDirect = sys_getloadavg();

            $loadAverages[1] = round($loadAveragesDirect[0], $precision);
            $loadAverages[2] = round($loadAveragesDirect[1], $precision);
            $loadAverages[3] = round($loadAveragesDirect[2], $precision);
            $loadAverages[4] = round(array_sum($loadAveragesDirect) / 3, $precision);

            $this->getCacheChain()->set($loadAverages, __METHOD__);
        }

        $this->getCacheChain()->setTtlToDefault();

        $loadAverages[0] = time();

        return (array) $loadAverages;
    }

    /**
     * @param int $precision
     *
     * @return int[]
     */
    public function getLoadAveragesAsPercent($precision = 2)
    {
        $coreCount = $this->getCoreCount();

        list($time, $load01, $load05, $load15, $loadAverage)
            = $this->getLoadAverages($precision)
        ;

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
    public function getCoreCount()
    {
        $this->getCacheChain()->setTtl(60 * 60 * 24);

        if (null !== ($cpuCount = $this->getCacheChain()->get(__METHOD__))) {
            $cpuCount = $this->getCoreCountPlatformLookup();
            $this->getCacheChain()->set($cpuCount, __METHOD__);
        }

        $this->getCacheChain()->setTtlToDefault();

        return (int) $cpuCount;
    }

    /**
     * @return int
     */
    protected function getCoreCountPlatformLookup()
    {
        $platform = SystemPlatform::getSystemPlatform();
        $cmd = new SystemExecute();

        switch ($platform) {
            case SystemPlatform::OS_LINUX:
                $cmd
                    ->start()
                    ->setCommand('cat /proc/stat | grep cpu[0-9]')
                    ->run()
                ;
                break;

            case SystemPlatform::OS_DARWIN:
                $cmd
                    ->start()
                    ->setCommand('sysctl hw.ncpu | cut -d " " -f 2')
                    ->run()
                ;
                break;
        }

        if ($cmd->isSuccess() !== true || count($cmd->getOutput()) > 1) {
            throw new RuntimeException(
                'The platform you are using does not support core count look-ups. "%s".',
                null, null, null, (string) $platform
            );
        }

        return (int) $cmd->getOutput()[0];
    }
}

/* EOF */
