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

namespace SR\Wonka\Utility\System\Storage;

use SR\Wonka\Exception\InvalidArgumentException;

/**
 * Class SystemStorage.
 */
class SystemStorage implements SystemStorageInterface
{
    /**
     * @param string $path
     *
     * @return bool
     */
    public function isPathAbsolute($path)
    {
        return (bool) (substr($path, 0, 1) === DIRECTORY_SEPARATOR);
    }

    /**
     * @param string[] $paths
     *
     * @return string
     */
    public function getSanitizedPath(...$paths)
    {
        return preg_replace('#'.DIRECTORY_SEPARATOR.'{2,}#', DIRECTORY_SEPARATOR, implode((array) $paths));
    }

    /**
     * @param string $path
     *
     * @return array
     */
    public function getPathExploded($path)
    {
        $pathParts = (array) explode(DIRECTORY_SEPARATOR, $this->getSanitizedPath($path));

        return array_values(array_filter($pathParts, function ($path) {
            return (bool) (strlen($path) > 0);
        }));
    }

    /**
     * @param array $pathParts
     *
     * @return string
     */
    public function getPathImploded(array $pathParts = [])
    {
        return (string) $this->getSanitizedPath(implode(DIRECTORY_SEPARATOR, $pathParts));
    }

    /**
     * @param string $path
     *
     * @return array
     */
    public function getPathExplodedConcat($path)
    {
        $pathParts = $this->getPathExploded($path);
        $pathPartsCount = count($pathParts);
        $pathAbsolute = $this->isPathAbsolute($path);
        $pathPartsConcat = [];

        for ($i = 0; $i < $pathPartsCount; ++$i) {
            $pathBuilderTemp = [];

            for ($j = $i; $j >= 0; --$j) {
                array_unshift($pathBuilderTemp, $pathParts[$j]);
            }

            if ($pathAbsolute === true) {
                array_unshift($pathBuilderTemp, DIRECTORY_SEPARATOR);
            }

            $pathPartsConcat[] = $this->getPathImploded($pathBuilderTemp);
        }

        return $pathPartsConcat;
    }

    /**
     * @param int    $inputSize
     * @param string $inputUnit
     * @param bool   $favorJedec
     *
     * @return int
     */
    public function getSizeConvertedHuman($inputSize, $inputUnit = 'B', $favorJedec = true)
    {
        list($unitIecKey, $unitBaseKey) = $this->getBaseConversionIndexFromUnitString($inputUnit);
    }

    /**
     * @param int    $inputSize
     * @param string $inputUnit
     * @param string $outputUnit
     * @param bool   $favorJedec
     *
     * @return mixed
     */
    public function getSizeConvertedBase($inputSize, $inputUnit = 'B', $outputUnit = 'GiB', $favorJedec = true)
    {
    }

    /**
     * @param string $unit
     *
     * @throws InvalidArgumentException
     *
     * @return int[]
     */
    protected function getBaseConversionIndexFromUnitString($unit)
    {
        foreach (self::UNIT_IEC_ABBR_NAME as $unitIecKey => $unitIecAbbr) {
            if (false !== ($unitBaseKey = array_search((string) $unit, (array) $unitIecAbbr, true))) {
                return [(int) $unitIecKey, (int) $unitBaseKey];
            }
        }

        throw new InvalidArgumentException('Invalid unit "%s" provided to "%s".', null, null, (string) $unit, __METHOD__);
    }
}

/* EOF */
