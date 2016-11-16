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

interface PasswordGeneratorInterface extends GeneratorInterface
{
    /**
     * The default length of the generated value.
     *
     * @var string
     */
    const DEFAULT_LENGTH = 20;

    /**
     * The default length of the generated value.
     *
     * @var string
     */
    const DEFAULT_ENTROPY = 100000;

    /**
     * Construct a generator by defining the length of the generated value.
     *
     * @param int $length
     */
    public function __construct(int $length = 20);
}

/* EOF */
