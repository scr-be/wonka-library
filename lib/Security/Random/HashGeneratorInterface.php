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

interface HashGeneratorInterface extends GeneratorInterface
{
    /**
     * @var string
     */
    const ALGORITHM_SHA256 = 'sha256';

    /**
     * @var string
     */
    const ALGORITHM_SHA384 = 'sha384';

    /**
     * @var string
     */
    const ALGORITHM_SHA512 = 'sha512';

    /**
     * @var string
     */
    const ALGORITHM_MD5 = 'md5';

    /**
     * @var string
     */
    const ALGORITHM_GOST = 'gost';

    /**
     * @var string
     */
    const ALGORITHM_DEFAULT = self::ALGORITHM_SHA512;

    /**
     * Construct a generator by defining the entropy for the generated value.
     *
     * @param string $algorithm
     * @param int    $entropy
     */
    public function __construct(string $algorithm = self::ALGORITHM_DEFAULT, int $entropy = 10000);

    /**
     * Static instance creation method.
     *
     * @param string        $algorithm
     * @param int           $entropy
     * @param \Closure|null $returnFilter
     *
     * @return HashGeneratorInterface
     */
    public static function create(string $algorithm = self::ALGORITHM_DEFAULT, int $entropy = 10000, \Closure $returnFilter = null) : HashGeneratorInterface;

    /**
     * Sets the hash algorithm to use.
     *
     * @param string $algorithm
     *
     * @return HashGeneratorInterface
     */
    public function setAlgorithm(string $algorithm) : HashGeneratorInterface;
}

/* EOF */
