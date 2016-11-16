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

interface BytesGeneratorInterface extends GeneratorInterface
{
    /**
     * Construct a generator by defining the length of the generated value.
     *
     * @param int $length
     */
    public function __construct(int $length = 1000);

    /**
     * Static instance creation method.
     *
     * @param int           $length
     * @param \Closure|null $returnFilter
     *
     * @return GeneratorInterface
     */
    public static function create(int $length = self::DEFAULT_LENGTH, \Closure $returnFilter = null) : BytesGeneratorInterface;

    /**
     * Set whether raw bytes are returned or not.
     *
     * @param bool $returnRaw
     *
     * @return BytesGeneratorInterface
     */
    public function setReturnRaw(bool $returnRaw = false) : BytesGeneratorInterface;
}

/* EOF */
