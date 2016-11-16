<?php

/*
 * This file is part of the `src-run/wonka-library` project.
 *
 * (c) Rob Frawley 2nd <rmf@src.run>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace SR\Wonka\Security\Random;

interface GeneratorInterface
{
    /**
     * Returns the generated value string.
     *
     * @return string
     */
    public function generate() : string;
}

/* EOF */
