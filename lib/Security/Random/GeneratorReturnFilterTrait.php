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

trait GeneratorReturnFilterTrait
{
    /**
     * @var bool
     */
    protected $returnFilter;

    /**
     * Set the filter closure to call on the generated return value.
     *
     * @param \Closure|null $returnFilter
     *
     * @return GeneratorInterface
     */
    public function setReturnFilter(\Closure $returnFilter = null) : GeneratorInterface
    {
        $this->returnFilter = $returnFilter;

        return $this;
    }
}

/* EOF */
