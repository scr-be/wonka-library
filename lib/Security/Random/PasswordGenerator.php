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
use SR\Wonka\Utility\Security\Password;

class PasswordGenerator extends AbstractGenerator implements PasswordGeneratorInterface
{
    /**
     * @var int
     */
    private $entropy = self::DEFAULT_ENTROPY;

    /**
     * List of special characters to use in password.
     *
     * @var string
     */
    private $specials = '!@#$%&*?';

    /**
     * Regular expression to require generated password adheres to.
     *
     * @var string
     */
    private $required = '{.*^(?=.{8,})(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*\W).*$}';

    /**
     * The number of iterations required to generate secure password.
     *
     * @var int
     */
    private $iterations = 0;

    /**
     * BytesGenerator constructor.
     *
     * @param int $length
     */
    public function __construct(int $length = 20)
    {
        $this->setLength($length);
    }

    /**
     * Static instance creation method.
     *
     * @param int           $length
     * @param int           $entropy
     * @param \Closure|null $returnFilter
     *
     * @return PasswordGeneratorInterface
     */
    public static function create(int $length = 20, int $entropy = self::DEFAULT_ENTROPY, \Closure $returnFilter = null) : PasswordGeneratorInterface
    {
        $instance = new static();

        $instance->setLength($length);
        $instance->setReturnFilter($returnFilter);

        return $instance;
    }

    /**
     * Set the length of the generated password.
     *
     * @param $length
     *
     * @throws InvalidArgumentException
     *
     * @return BytesGeneratorInterface
     */
    public function setLength(int $length) : GeneratorInterface
    {
        if ($length < 8) {
            throw new InvalidArgumentException('Cannot generate random password with length of "%d" as value of 8 or more is required.', $length);
        }

        return parent::setLength($length);
    }

    /**
     * Set the amount of random bytes entropy to use for the password.
     *
     * @param $entropy
     *
     * @throws InvalidArgumentException
     *
     * @return BytesGeneratorInterface
     */
    public function setEntropy(int $entropy) : PasswordGeneratorInterface
    {
        $this->entropy = $entropy;

        return $this;
    }

    /**
     * Set the special characters to use in the generated password.
     *
     * @param string $specials
     *
     * @return PasswordGeneratorInterface
     */
    public function setSpecials(string $specials) : PasswordGeneratorInterface
    {
        $this->specials = $specials;

        return $this;
    }

    /**
     * Set the regular expression requirements for generated passwords.
     *
     * @param string $specials
     *
     * @return PasswordGeneratorInterface
     */
    public function setRequired(string $required) : PasswordGeneratorInterface
    {
        $this->required = $required;

        return $this;
    }

    /**
     * Returns the number of generator iterations required to create secure password.
     *
     * @return int
     */
    public function getIterations() : int
    {
        return $this->iterations;
    }

    /**
     * Generate and return the random bytes based on the configuration.
     *
     * @return string
     */
    public function generate() : string
    {
        $this->iterations = 0;

        do {
            $generated = $this->tryGeneration($this->getBytesGenerator());
        } while (++$this->iterations && !$this->isSecure($generated));

        if ($this->returnFilter) {
            $generated = ($this->returnFilter)($generated);
        }

        return $generated;
    }

    /**
     * @return BytesGenerator
     */
    private function getBytesGenerator()
    {
        $generator = new BytesGenerator();
        $generator->setReturnRaw(false);
        $generator->setLength($this->entropy);

        return $generator;
    }

    /**
     * @param BytesGeneratorInterface $generator
     *
     * @return string
     */
    private function tryGeneration(BytesGeneratorInterface $generator)
    {
        $proposed = $this->buildGeneratedFromAvailable($g = $generator->generate());
        $proposed = $this->alterGeneratedAddUppercase($proposed);
        $proposed = $this->alterGeneratedAddSpecialChars($proposed);

        return $proposed;
    }

    /**
     * @param string $available
     *
     * @return string
     */
    private function buildGeneratedFromAvailable(string $available)
    {
        $generated = '';

        foreach (range(1, $this->length) as $i) {
            $generated .= $available[mt_rand(0, strlen($available) - 1)];
        }

        return $generated;
    }

    /**
     * @param string $generated
     *
     * @return string
     */
    private function alterGeneratedAddUppercase(string $generated)
    {
        $length = strlen($generated);

        for ($i = 0; $i < $length / 2; ++$i) {
            $generated[$index = mt_rand(0, $length - 1)] = strtoupper($generated[$index]);
        }

        return $generated;
    }

    /**
     * @param string $generated
     *
     * @return string
     */
    private function alterGeneratedAddSpecialChars(string $generated)
    {
        $length = strlen($generated);

        for ($i = 0; $i < $length / 4; ++$i) {
            $generated[mt_rand(0, $length - 1)] = substr(str_shuffle($this->specials), 0, 1);
        }

        return $generated;
    }

    /**
     * @param string $generated
     *
     * @return bool
     */
    private function isSecure($generated)
    {
        return 1 === preg_match($this->required, $generated);
    }
}

/* EOF */
