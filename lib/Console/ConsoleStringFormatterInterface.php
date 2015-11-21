<?php

/*
 * This file is part of the scribe/wonka-bundle.
 *
 * (c) Scribe Inc. <rmf@scr.be>
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
    static public function outLine($string, ...$replacements);

    /**
     * @param string    $string
     * @param mixed,... $replacements
     */
    static public function out($string, ...$replacements);

    /**
     * @param string    $string
     * @param mixed,... $replacements
     *
     * @return string
     */
    static public function render($string, ...$replacements);

    /**
     * @return string
     */
    static public function getColorTerminationCode();
}

/* EOF */