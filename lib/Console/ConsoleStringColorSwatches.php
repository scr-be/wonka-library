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
        'R%'    => '\e[0m',
        'k%'    => '\e[0;30m',
        'r%'    => '\e[0;31m',
        'g%'    => '\e[0;32m',
        'y%'    => '\e[0;33m',
        'b%'    => '\e[0;34m',
        'p%'    => '\e[0;35m',
        'c%'    => '\e[0;36m',
        'w%'    => '\e[0;37m',
        'k%b'   => '\e[1;30m',
        'r%b'   => '\e[1;31m',
        'g%b'   => '\e[1;32m',
        'y%b'   => '\e[1;33m',
        'b%b'   => '\e[1;34m',
        'p%b'   => '\e[1;35m',
        'c%b'   => '\e[1;36m',
        'w%b'   => '\e[1;37m',
        'k%u'   => '\e[4;30m',
        'r%u'   => '\e[4;31m',
        'g%u'   => '\e[4;32m',
        'y%u'   => '\e[4;33m',
        'b%u'   => '\e[4;34m',
        'p%u'   => '\e[4;35m',
        'c%u'   => '\e[4;36m',
        'w%u'   => '\e[4;37m',
        'k%on'  => '\e[40m',
        'r%on'  => '\e[41m',
        'g%on'  => '\e[42m',
        'y%on'  => '\e[43m',
        'b%on'  => '\e[44m',
        'p%on'  => '\e[45m',
        'c%on'  => '\e[46m',
        'w%on'  => '\e[47m',
        'k%i'   => '\e[0;90m',
        'r%i'   => '\e[0;91m',
        'g%i'   => '\e[0;92m',
        'y%i'   => '\e[0;93m',
        'b%i'   => '\e[0;94m',
        'p%i'   => '\e[0;95m',
        'c%i'   => '\e[0;96m',
        'w%i'   => '\e[0;97m',
        'k%bi'  => '\e[1;90m',
        'r%bi'  => '\e[1;91m',
        'g%bi'  => '\e[1;92m',
        'y%bi'  => '\e[1;93m',
        'b%bi'  => '\e[1;94m',
        'p%bi'  => '\e[1;95m',
        'c%bi'  => '\e[1;96m',
        'w%bi'  => '\e[1;97m',
        'k%oni' => '\e[0;100m',
        'r%oni' => '\e[0;101m',
        'g%oni' => '\e[0;102m',
        'y%oni' => '\e[0;103m',
        'b%oni' => '\e[0;104m',
        'p%oni' => '\e[0;105m',
        'c%oni' => '\e[0;106m',
        'w%oni' => '\e[0;107m'
    ];
}

/* EOF */