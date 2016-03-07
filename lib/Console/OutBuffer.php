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
 * Class OutBuffer.
 */
class OutBuffer extends ConsoleStringFormatter
{
    /**
     * @var string
     */
    const CFG_PRE = 'linePrefix';

    /**
     * @var string
     */
    const CFG_LEN = 'lineLength';

    /**
     * @var string[]
     */
    protected static $buffer;

    /**
     * @var string
     */
    protected static $linePrefix = '';

    /**
     * @var int
     */
    protected static $lineLength = 200;

    public static function make()
    {
        self::conf([self::CFG_PRE => '    ']);
    }

    /**
     * @param string    $message
     * @param mixed,... $replacements
     */
    public static function stat($message, ...$replacements)
    {
        self::make();
        self::line($message);
        self::show(...$replacements);
    }

    /**
     * @param mixed[] $config
     */
    public static function conf(array $config = [])
    {
        foreach ($config as $cfg => $val) {
            self::${(string) $cfg} = $val;
        }
        self::addConfigToBuffer();
    }

    /**
     * @param string $str
     */
    public static function line($str)
    {
        self::$buffer[] = (string) $str;
    }

    /**
     * @param mixed,... $replacements
     */
    public static function show(...$replacements)
    {
        echo self::getOutputFromBuffer($replacements);
        static::$buffer = [];
    }

    /**
     */
    protected static function addConfigToBuffer()
    {
        self::$buffer[] = [
            'prefix' => self::$linePrefix,
        ];
    }

    protected static function getOutputFromBuffer(array $replacements = [])
    {
        $lines = self::getOutputLinesConcatFromBuffer();
        $lines = self::getOutputLinesWithSubstitutions($lines, $replacements);
        $prefix = '';
        $output = '';
        $tmp = '';
        $first = true;

        foreach ($lines as $i => $line) {
            if (isset($line['prefix'])) {
                $prefix = $line['prefix'];
                continue;
            }

            if ($i == 0) {
                continue;
            }

            $tmp .= $line;
        }

        do {
            $more = 0;
            $matches = 0;
            $outputTmp = substr($tmp, 0, self::$lineLength);
            preg_match_all('{\[([0-9]+;)?[0-9]+m}i', $outputTmp, $matches);
            if (isset($matches[0][0])) {
                $more = strlen($matches[0][0]) + (count($matches[0]) * 3);
                $outputTmp = substr($tmp, 0, (self::$lineLength + $more));
            }
            if ($first !== true) {
                $output .= '  ';
            }
            $output .= $prefix.trim($outputTmp)."\n";
            $tmp = substr($tmp, self::$lineLength + $more);
            $first = false;
        } while (strlen($tmp) >= self::$lineLength);

        if (strlen($tmp) > 0) {
            $output .= '  '.$prefix.trim($tmp)."\n";
        }

        return $output.self::getColorTerminationCode();
    }

    protected static function getOutputLinesConcatFromBuffer()
    {
        $output[] = "\n";

        foreach (self::$buffer as $i => $b) {
            if (isset($b['prefix'])) {
                $output[] = ['prefix' => $b['prefix']];
                $iterator = count($output);
                continue;
            }

            $output[$iterator] = (@$output[$iterator]).' '.$b;
        }

        return $output;
    }

    /**
     * @param array $lines
     * @param array $replacements
     *
     * @return array
     */
    protected static function getOutputLinesWithSubstitutions(array $lines, array $replacements)
    {
        array_walk($lines, function (&$l) {
            if (isset($l['prefix'])) {
                return null;
            }
            $l = self::performColorPlaceholderSubstitutions($l);
        });

        if (count($replacements) == 0) {
            return $lines;
        }

        $temp = array_filter($lines, function ($l) {
            return (bool) !is_array($l);
        });

        $temp = implode($temp, 'abcdefg!@#$^&');
        $temp = self::performReplacementSubstitutions($temp, $replacements);
        $temp = explode('abcdefg!@#$^&', $temp);

        array_walk($lines, function (&$l) use (&$temp) {
            if (isset($l['prefix'])) {
                return null;
            }
            $l = array_shift($temp);
        });

        return $lines;
    }
}

/* EOF */
