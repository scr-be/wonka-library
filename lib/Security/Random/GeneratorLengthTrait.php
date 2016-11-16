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

trait GeneratorLengthTrait
{
    /**
     * @var int
     */
    protected $length;

    /**
     * Set the length of the generated return value.
     *
     * @param int $length
     *
     * @throws InvalidArgumentException
     *
     * @return GeneratorInterface
     */
    public function setLength(int $length) : GeneratorInterface
    {
        if ($length < 1) {
            throw new InvalidArgumentException('Generator length value provided "%d" must be non-zero, positive value', $length);
        }

        $this->length = $length;

        return $this;
    }
}

/* EOF */
