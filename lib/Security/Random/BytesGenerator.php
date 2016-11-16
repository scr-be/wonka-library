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

class BytesGenerator implements BytesGeneratorInterface
{
    use GeneratorLengthTrait;
    use GeneratorReturnFilterTrait;
    use GeneratorReturnRawTrait;

    /**
     * BytesGenerator constructor.
     *
     * @param int $length
     */
    public function __construct(int $length = 1000)
    {
        $this->setLength($length);
    }

    /**
     * Static instance creation method.
     *
     * @param int           $length
     * @param \Closure|null $returnFilter
     *
     * @return BytesGeneratorInterface
     */
    public static function create(int $length = 1000, \Closure $returnFilter = null) : BytesGeneratorInterface
    {
        $instance = new static();

        $instance->setLength($length);
        $instance->setReturnFilter($returnFilter);

        return $instance;
    }

    /**
     * Generate and return the random bytes based on the configuration.
     *
     * @return string
     */
    public function generate() : string
    {
        $generated = random_bytes($this->length);

        if (!$this->returnRaw) {
            $generated = bin2hex($generated);
        }

        if ($this->returnFilter) {
            $generated = ($this->returnFilter)($generated);
        }

        return substr($generated, 0, $this->length);
    }
}

/* EOF */
