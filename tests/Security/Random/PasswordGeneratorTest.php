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
 * @covers \SR\Wonka\Security\Random\AbstractGenerator
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

    public function testGeneratorLengthExceptionOnLessThanEightValue()
    {
        $generator = new PasswordGenerator();

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Cannot generate random password with length of "4" as value of 8 or more is required.');
        $generator->setLength(4);
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
}

/* EOF */
