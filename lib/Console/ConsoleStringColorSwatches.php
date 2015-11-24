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
 * Trait ColorSwatches.
 */
trait ConsoleStringColorSwatches
{
    static public $colors = [
        "+R/-"    => "\033[0m",
        "+k/-"    => "\033[0;30m",
        "+r/-"    => "\033[0;31m",
        "+g/-"    => "\033[0;32m",
        "+y/-"    => "\033[0;33m",
        "+b/-"    => "\033[0;34m",
        "+p/-"    => "\033[0;35m",
        "+c/-"    => "\033[0;36m",
        "+w/-"    => "\033[0;37m",
        "+k/b-"   => "\033[1;30m",
        "+r/b-"   => "\033[1;31m",
        "+g/b-"   => "\033[1;32m",
        "+y/b-"   => "\033[1;33m",
        "+b/b-"   => "\033[1;34m",
        "+p/b-"   => "\033[1;35m",
        "+c/b-"   => "\033[1;36m",
        "+w/b-"   => "\033[1;37m",
        "+k/u-"   => "\033[4;30m",
        "+r/u-"   => "\033[4;31m",
        "+g/u-"   => "\033[4;32m",
        "+y/u-"   => "\033[4;33m",
        "+b/u-"   => "\033[4;34m",
        "+p/u-"   => "\033[4;35m",
        "+c/u-"   => "\033[4;36m",
        "+w/u-"   => "\033[4;37m",
        "+k/on-"  => "\033[40m",
        "+r/on-"  => "\033[41m",
        "+g/on-"  => "\033[42m",
        "+y/on-"  => "\033[43m",
        "+b/on-"  => "\033[44m",
        "+p/on-"  => "\033[45m",
        "+c/on-"  => "\033[46m",
        "+w/on-"  => "\033[47m",
        "+k/i-"   => "\033[0;90m",
        "+r/i-"   => "\033[0;91m",
        "+g/i-"   => "\033[0;92m",
        "+y/i-"   => "\033[0;93m",
        "+b/i-"   => "\033[0;94m",
        "+p/i-"   => "\033[0;95m",
        "+c/i-"   => "\033[0;96m",
        "+w/i-"   => "\033[0;97m",
        "+k/bi-"  => "\033[1;90m",
        "+r/bi-"  => "\033[1;91m",
        "+g/bi-"  => "\033[1;92m",
        "+y/bi-"  => "\033[1;93m",
        "+b/bi-"  => "\033[1;94m",
        "+p/bi-"  => "\033[1;95m",
        "+c/bi-"  => "\033[1;96m",
        "+w/bi-"  => "\033[1;97m",
        "+k/oni-" => "\033[0;100m",
        "+r/oni-" => "\033[0;101m",
        "+g/oni-" => "\033[0;102m",
        "+y/oni-" => "\033[0;103m",
        "+b/oni-" => "\033[0;104m",
        "+p/oni-" => "\033[0;105m",
        "+c/oni-" => "\033[0;106m",
        "+w/oni-" => "\033[0;107m"
    ];
}

/* EOF */