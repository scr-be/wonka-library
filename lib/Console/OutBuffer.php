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
 * Class OutBuffer.
 */
class OutBuffer extends ConsoleStringFormatter
{
    /**
     * @var string
     */
    const CFG_PRE="linePrefix";

    /**
     * @var string
     */
    const CFG_LEN="lineLength";

    /**
     * @var array[]
     */
    protected static $bufferLines = [];

    /**
     * @var string[]
     */
    protected static $buffer = [];

    /**
     * @var string
     */
    protected static $linePrefix = '';

    /**
     * @var int
     */
    protected static $lineLength = 120;

    /**
     * @param mixed[] $config
     */
    static public function conf(array $config = [])
    {
        foreach ($config as $cfg => $val) {
            static::${(string) $cfg} = $val;
        }
    }

    /**
     * @param string $str
     */
    static public function open($str)
    {
        if (count(static::$buffer) > 0) {
            static::$buffer[1];
        }

        static::$buffer[count(static::$buffer)] = [
            'open' => static::getActiveConfig()
        ];

        static::line($str);
    }

    /**
     * @param string $str
     */
    static public function line($str)
    {
        static::$buffer[count(static::$buffer)][] = (string) $str;
    }

    static public function done(...$subs)
    {
        $out = static::prepareOutputFromBuffer();
    }

    static protected function getActiveConfig()
    {
        return [
            'prefix' => static::$linePrefix,
            'length' => static::$lineLength,
        ];
    }

    static protected function prepareOutputFromBuffer()
    {
        $output = [];
        $buffer = static::$buffer;
        $config = static::getActiveConfig();

        array_walk($buffer, function (&$b) {
            if (!isset($b['open'])) { $b = static::render($b); }
        });

        foreach ($buffer as $i => $b) {
            if ($i == 1) {
                $output[] = "\n";
            }

            if (isset($b['open'])) {
                $config = $b['open'];
                $output[] = $config['buffer'];

                next($output);
                continue;
            }

            while (strlen($o = current($output) . $b) > $config['length']) {
                $output[key($output)] = substr($o, 0, $config['length']);
                $output[] = $config['prefix'] . substr($o, strlen($output[key($output)-1]));

                next($output);
            }
        }


    }

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