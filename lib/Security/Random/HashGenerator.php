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

class HashGenerator implements HashGeneratorInterface
{
    use GeneratorBytesInstanceAware;
    use GeneratorEntropyTrait;
    use GeneratorReturnFilterTrait;
    use GeneratorReturnRawTrait;

    /**
     * @var string
     */
    private $algorithm = self::ALGORITHM_DEFAULT;

    /**
     * Construct a generator by defining the entropy for the generated value.
     *
     * @param string $algorithm
     * @param int    $entropy
     */
    public function __construct(string $algorithm = self::ALGORITHM_DEFAULT, int $entropy = 10000)
    {
        $this->setAlgorithm($algorithm);
        $this->setEntropy($entropy);
    }

    /**
     * Static instance creation method.
     *
     * @param string        $algorithm
     * @param int           $entropy
     * @param \Closure|null $returnFilter
     *
     * @return HashGeneratorInterface
     */
    public static function create(string $algorithm = self::ALGORITHM_DEFAULT, int $entropy = 10000, \Closure $returnFilter = null) : HashGeneratorInterface
    {
        $instance = new static();

        $instance->setAlgorithm($algorithm);
        $instance->setEntropy($entropy);
        $instance->setReturnFilter($returnFilter);

        return $instance;
    }

    /**
     * Sets the hash algorithm to use.
     *
     * @param string $algorithm
     *
     * @return HashGeneratorInterface
     */
    public function setAlgorithm(string $algorithm) : HashGeneratorInterface
    {
        $this->algorithm = $algorithm;

        return $this;
    }

    /**
     * Generate and return the random bytes based on the configuration.
     *
     * @return string
     */
    public function generate() : string
    {
        $generated = $this->instantiateBytesGenerator($this->entropy)->generate();
        $generated = hash($this->algorithm, $generated, $this->returnRaw);

        if ($this->returnFilter) {
            $generated = ($this->returnFilter)($generated);
        }

        return $generated;
    }
}

/* EOF */
