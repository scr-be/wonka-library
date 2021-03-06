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
     * Construct a generator by defining the length of the generated value.
     *
     * @param int $length
     */
    public function __construct(int $length = 20);

    /**
     * Static instance creation method.
     *
     * @param int           $length
     * @param int           $entropy
     * @param \Closure|null $returnFilter
     *
     * @return PasswordGeneratorInterface
     */
    public static function create(int $length = 20, int $entropy = 1000, \Closure $returnFilter = null) : PasswordGeneratorInterface;

    /**
     * Set the length of the random bytes to generate.
     *
     * @param $length
     *
     * @return GeneratorInterface
     */
    public function setLength(int $length) : GeneratorInterface;

    /**
     * Set closure to call on generated bytes prior to returning the value.
     *
     * @param \Closure|null $filter
     *
     * @return GeneratorInterface
     */
    public function setReturnFilter(\Closure $filter = null) : GeneratorInterface;
}

/* EOF */
