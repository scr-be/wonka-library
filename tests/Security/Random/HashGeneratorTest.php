<?php

/*
 * This file is part of the `src-run/wonka-library` project.
 *
 * (c) Rob Frawley 2nd <rmf@src.run>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace SR\Wonka\Tests\Security\Random;

use SR\Wonka\Security\Random\HashGenerator;

/**
 * Class HashGeneratorTest.
 *
 * @covers \SR\Wonka\Security\Random\HashGenerator
 * @covers \SR\Wonka\Security\Random\HashGeneratorInterface
 */
class HashGeneratorDisabled extends \PHPUnit_Framework_TestCase
{
    public function testConstruction()
    {
        $this->assertInstanceOf(HashGenerator::class, new HashGenerator());
    }

    public function testStaticConstruction()
    {
        $this->assertInstanceOf(HashGenerator::class, HashGenerator::create());
    }

    public function testGenerator()
    {
        $generator = new HashGenerator();
        $generated = $generator->generate();

        $this->assertSame(128, strlen($generated));
    }

    public function testGeneratorReturnFilter()
    {
        $generator = new HashGenerator();
        $generator->setReturnFilter(function (string $generated) {
            return preg_replace('{[^0-9]}', '', $generated);
        });
        $generated = $generator->generate();

        $this->assertNotSame(128, strlen($generated));
        $this->assertRegExp('{[0-9]}i', $generated);
    }

    public function testGeneratorAlgorithms()
    {
        $generator = new HashGenerator();
        $generator->setReturnRaw(false);

        $generator->setAlgorithm(HashGenerator::ALGORITHM_SHA256);
        $this->assertSame(64, strlen($generator->generate()));

        $generator->setAlgorithm(HashGenerator::ALGORITHM_SHA384);
        $this->assertSame(96, strlen($generator->generate()));

        $generator->setAlgorithm(HashGenerator::ALGORITHM_SHA512);
        $this->assertSame(128, strlen($generator->generate()));

        $generator->setAlgorithm(HashGenerator::ALGORITHM_GOST);
        $this->assertSame(64, strlen($generator->generate()));

        $generator->setAlgorithm(HashGenerator::ALGORITHM_MD5);
        $this->assertSame(32, strlen($generator->generate()));
    }
}

/* EOF */
