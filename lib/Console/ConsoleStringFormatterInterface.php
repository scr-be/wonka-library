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

namespace Scribe\Wonka\Console;

/**
 * Interface ConsoleStringFormatterInterface.
 */
interface ConsoleStringFormatterInterface
{
    /**
     * @param string    $string
     * @param mixed,... $replacements
     */
    public static function outLine($string, ...$replacements);

    /**
     * @param string    $string
     * @param mixed,... $replacements
     */
    public static function out($string, ...$replacements);

    /**
     * @param string    $string
     * @param mixed,... $replacements
     *
     * @return string
     */
    public static function render($string, ...$replacements);

    /**
     * @return string
     */
    public static function getColorTerminationCode();
}

/* EOF */
