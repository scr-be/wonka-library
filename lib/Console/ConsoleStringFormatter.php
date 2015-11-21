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

use Scribe\Wonka\Utility\StaticClass\StaticClassTrait;

/**
 * Class ConsoleStringFormatter.
 */
class ConsoleStringFormatter implements ConsoleStringFormatterInterface
{
    use ConsoleStringColorSwatches;
    use StaticClassTrait;

    /**
     * @param string    $string
     * @param mixed,... $replacements
     */
    static public function outLine($string, ...$replacements)
    {
        static::out($string, ...$replacements);
        echo PHP_EOL;
    }

    /**
     * @param string    $string
     * @param mixed,... $replacements
     */
    static public function out($string, ...$replacements)
    {
        echo static::render($string, ...$replacements);
    }

    /**
     * @param string    $string
     * @param mixed,... $replacements
     *
     * @return string
     */
    static public function render($string, ...$replacements)
    {
        return (string) static::performColorPlaceholderSubstitutions(
            static::performReplacementSubstitutions($string, $replacements)
        );
    }

    /**
     * @return string
     */
    static public function getColorTerminationCode()
    {
        return (string) ConsoleStringColorSwatches::$colors['R%'];
    }

    /**
     * @param string     $string
     * @param array|null $replacements
     *
     * @return string
     */
    static protected function performReplacementSubstitutions($string, array $replacements = null)
    {
        return (string) ($replacements ? $string : sprintf((string) $string, ...$replacements));
    }

    /**
     * @param string $string
     *
     * @return string
     */
    static protected function performColorPlaceholderSubstitutions($string)
    {
        foreach (ConsoleStringColorSwatches::$colors as $colorKey => $colorVal) {
            $string = str_replace($colorKey, $colorVal, $string);
        }

        return (string) ($string.self::getColorTerminationCode());
    }
}

/* EOF */