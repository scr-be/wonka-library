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

use SR\Exception\Logic\InvalidArgumentException;
use SR\Wonka\Security\Random\PasswordGenerator;

/**
 * Class PasswordGeneratorTest.
 *
 * @covers \SR\Wonka\Security\Random\GeneratorBytesInstanceAware
 * @covers \SR\Wonka\Security\Random\GeneratorEntropyTrait
 * @covers \SR\Wonka\Security\Random\GeneratorLengthTrait
 * @covers \SR\Wonka\Security\Random\GeneratorReturnFilterTrait
 * @covers \SR\Wonka\Security\Random\GeneratorReturnRawTrait
 * @covers \SR\Wonka\Security\Random\PasswordGenerator
 * @covers \SR\Wonka\Security\Random\PasswordGeneratorInterface
 */
class PasswordGeneratorTest extends \PHPUnit_Framework_TestCase
{
    public function testConstruction()
    {
        $this->assertInstanceOf(PasswordGenerator::class, new PasswordGenerator());
    }

    public function testStaticConstruction()
    {
        $this->assertInstanceOf(PasswordGenerator::class, PasswordGenerator::create());
    }

    public function testGenerator()
    {
        $generator = new PasswordGenerator();
        $generated = $generator->generate();

        $this->assertSame(20, strlen($generated));
        $this->assertRegExp('{.*^(?=.{8,})(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*\W).*$}', $generated);
        $this->assertGreaterThan(0, $generator->getIterations());
    }

    public function testCustomGenerator()
    {
        $generator = new PasswordGenerator();
        $generator->setEntropy(100000);
        $generator->setLength(18);
        $generator->setSpecials('!');
        $generator->setRequired('{[!]{4}}');

        do {
            $generated = $generator->generate();
        } while ($generator->getIterations() === 1);

        $this->assertSame(18, strlen($generated));
        $this->assertGreaterThan(1, $generator->getIterations());
    }

    public function testReturnFilter()
    {
        $generator = new PasswordGenerator();
        $generator->setEntropy(100000);
        $generator->setLength(100);
        $generator->setReturnFilter(function (string $generated) {
            return preg_replace('{[a-z]}', ':', $generated);
        });
        $generated = $generator->generate();

        $this->assertRegExp('{[:]*}', $generated);
        $this->assertRegExp('{[^a-z]}', $generated);
    }

    public function testGeneratorLengthExceptionOnLessThanEightValue()
    {
        $generator = new PasswordGenerator();

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Generator length value provided "4" must be greater than eight');
        $generator->setLength(4);
    }

    public function testGeneratorEntropyExceptionOnLessThanEightValue()
    {
        $generator = new PasswordGenerator();

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Generator entropy value provided "0" must be non-zero, positive value');
        $generator->setEntropy(0);
    }
}

/* EOF */
