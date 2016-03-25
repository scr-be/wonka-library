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

namespace SR\Wonka\Console;

use SR\Wonka\Utility\StaticClass\StaticClassTrait;

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
    public static function outLine($string, ...$replacements)
    {
        static::out($string, ...$replacements);
        echo PHP_EOL;
    }

    /**
     * @param string    $string
     * @param mixed,... $replacements
     */
    public static function out($string, ...$replacements)
    {
        echo static::render($string, ...$replacements);
    }

    /**
     * @param string    $string
     * @param mixed,... $replacements
     *
     * @return string
     */
    public static function render($string, ...$replacements)
    {
        return (string) static::performColorPlaceholderSubstitutions(
            static::performReplacementSubstitutions($string, $replacements)
        );
    }

    /**
     * @return string
     */
    public static function getColorTerminationCode()
    {
        return (string) ConsoleStringColorSwatches::$colors['+R/-'];
    }

    /**
     * @param string     $string
     * @param array|null $replacements
     *
     * @return string
     */
    protected static function performReplacementSubstitutions($string, array $replacements = [])
    {
        return (string) (count($replacements) == 0 ? $string : sprintf($string, ...$replacements));
    }

    /**
     * @param string $string
     *
     * @return string
     */
    protected static function performColorPlaceholderSubstitutions($string)
    {
        foreach (ConsoleStringColorSwatches::$colors as $colorKey => $colorVal) {
            $string = str_replace($colorKey, $colorVal, $string);
        }

        return (string) ($string.self::getColorTerminationCode());
    }

    protected static function getOutputLinesWithColorRemoved($lines)
    {
        array_walk($lines, function (&$l) {
            foreach (ConsoleStringColorSwatches::$colors as $colorKey => $colorVal) {
                $l = str_replace($colorVal, '', $l);
            }
        });

        return $lines;
    }
}

/* EOF */
