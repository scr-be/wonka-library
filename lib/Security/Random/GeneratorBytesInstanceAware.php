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

trait GeneratorBytesInstanceAware
{
    /**
     * @param int  $length
     * @param bool $returnRaw
     *
     * @return BytesGenerator
     */
    protected function instantiateBytesGenerator(int $length, $returnRaw = false)
    {
        return BytesGenerator::create()
            ->setReturnRaw($returnRaw)
            ->setLength($length);
    }
}

/* EOF */
