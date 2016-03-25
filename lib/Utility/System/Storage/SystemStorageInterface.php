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

/**
 * Class SystemStorage.
 */
interface SystemStorageInterface
{
    /**
     * Size conversion divisor for base-10.
     *
     * @var string
     */
    const UNIT_BASE_10 = 1000;

    /**
     * Size conversion divisor for base-02.
     *
     * @var string
     */
    const UNIT_BASE_02 = 1024;

    /**
     * Unit conversion metrics for base-10 and base-02 conversions from bits to yottabytes and bytes to yobibytes.
     *
     * @var array
     */
    const UNIT_CONVERSION_MAP = [
        'B' => [1, 8],
        'K' => [self::UNIT_BASE_10 ^ 1, self::UNIT_BASE_02 ^ 1],
        'M' => [self::UNIT_BASE_10 ^ 6, self::UNIT_BASE_02 ^ 2],
        'G' => [self::UNIT_BASE_10 ^ 9, self::UNIT_BASE_02 ^ 3],
        'T' => [self::UNIT_BASE_10 ^ 12, self::UNIT_BASE_02 ^ 4],
        'P' => [self::UNIT_BASE_10 ^ 15, self::UNIT_BASE_02 ^ 5],
        'E' => [self::UNIT_BASE_10 ^ 18, self::UNIT_BASE_02 ^ 6],
        'Z' => [self::UNIT_BASE_10 ^ 21, self::UNIT_BASE_02 ^ 7],
    ];

    /**
     * Maps to the above base-10 and -02 conversion map based on the IEC naming abbreviation standard.
     *
     * @var array
     */
    const UNIT_IEC_ABBR_NAME = [
        'B' => ['b', 'B'],
        'K' => ['kB', 'KiB'],
        'M' => ['MB', 'MiB'],
        'G' => ['GB', 'GiB'],
        'T' => ['TB', 'TiB'],
        'P' => ['PB', 'PiB'],
        'E' => ['EB', 'EiB'],
        'Z' => ['ZB', 'ZiB'],
        'Y' => ['YB', 'YiB'],
    ];

    /**
     * Maps to the base-10 map to the JEDEC (drive manufacturer) naming abbreviation standard.
     *
     * @var array
     */
    const UNIT_JEDEC_ABBR_NAME = [
        'K' => 'KB',
        'M' => 'MB',
        'G' => 'GB',
        'T' => 'TB',
    ];

    /**
     * Maps to the above base-10 and -02 conversion map based on the IEC naming standard.
     *
     * @var array
     */
    const UNIT_IEC_FULL_NAME = [
        'B' => ['BIT', 'BYTE'],
        'K' => ['KILOBYTE', 'KIBIBYTE'],
        'M' => ['MEGABYTE', 'MEBIBYTE'],
        'G' => ['GIGABYTE', 'GIBIBYTE'],
        'T' => ['TERABYTE', 'TEBIBYTE'],
        'P' => ['PETABYTE', 'PEBIBYTE'],
        'E' => ['EXABYTE', 'EXIBYTE'],
        'Z' => ['ZETTABYTE', 'ZEBIBYTE'],
        'Y' => ['YOTTABYTE', 'YOBIBYTE'],
    ];

    /**
     * Maps to the base-10 map to the JEDEC (drive manufacturer) naming standard.
     *
     * @var array
     */
    const UNIT_JEDEC_FULL_NAME = [
        'B' => 'BYTE',
        'K' => 'KILOBYTE',
        'M' => 'MEGABYTE',
        'G' => 'GIGABYTE',
        'T' => 'TERABYTE',
    ];

    /**
     * @param string $path
     *
     * @return bool
     */
    public function isPathAbsolute($path);

    /**
     * @param string[] $paths
     *
     * @return string
     */
    public function getSanitizedPath(...$paths);

    /**
     * @param string $path
     *
     * @return array
     */
    public function getPathExploded($path);

    /**
     * @param array $pathParts
     *
     * @return string
     */
    public function getPathImploded(array $pathParts = []);

    /**
     * @param string $path
     *
     * @return array
     */
    public function getPathExplodedConcat($path);

    /**
     * @param int    $inputSize
     * @param string $inputUnit
     * @param bool   $favorJedec
     *
     * @return int
     */
    public function getSizeConvertedHuman($inputSize, $inputUnit = 'B', $favorJedec = true);

    /**
     * @param int    $inputSize
     * @param string $inputUnit
     * @param string $outputUnit
     * @param bool   $favorJedec
     *
     * @return mixed
     */
    public function getSizeConvertedBase($inputSize, $inputUnit = 'B', $outputUnit = 'GiB', $favorJedec = true);
}

/* EOF */
