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

use SR\Exception\Logic\InvalidArgumentException;

trait GeneratorEntropyTrait
{
    /**
     * @var int
     */
    protected $entropy = 1000;

    /**
     * Set the entropy of the generated return value.
     *
     * @param int $entropy
     *
     * @throws InvalidArgumentException
     *
     * @return GeneratorInterface
     */
    public function setEntropy(int $entropy) : GeneratorInterface
    {
        if ($entropy < 1) {
            throw new InvalidArgumentException('Generator entropy value provided "%d" must be non-zero, positive value', $entropy);
        }

        $this->entropy = $entropy;

        return $this;
    }
}

/* EOF */
