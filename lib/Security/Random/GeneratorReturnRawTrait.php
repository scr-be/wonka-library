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

trait GeneratorReturnRawTrait
{
    /**
     * @var bool
     */
    protected $returnRaw;

    /**
     * Set whether raw bytes are returned or not.
     *
     * @param bool $returnRaw
     *
     * @return GeneratorInterface
     */
    public function setReturnRaw(bool $returnRaw = false) : GeneratorInterface
    {
        $this->returnRaw = $returnRaw;

        return $this;
    }
}

/* EOF */
