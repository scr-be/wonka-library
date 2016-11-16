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
use SR\Wonka\Security\Random\BytesGenerator;

/**
 * Class BytesGeneratorTest.
 *
 * @covers \SR\Wonka\Security\Random\AbstractGenerator
 * @covers \SR\Wonka\Security\Random\BytesGenerator
 * @covers \SR\Wonka\Security\Random\BytesGeneratorInterface
 */
class BytesGeneratorTest extends \PHPUnit_Framework_TestCase
{
    public function testConstruction()
    {
        $this->assertInstanceOf(BytesGenerator::class, new BytesGenerator());
    }

    public function testStaticConstruction()
    {
        $this->assertInstanceOf(BytesGenerator::class, BytesGenerator::create());
    }

    public function testGeneratorLength()
    {
        $generator = new BytesGenerator();
        $generator->setReturnRaw(true);

        foreach (range(1, 1000) as $length) {
            $generator->setLength($length);
            $this->assertSame($length, strlen($generator->generate()));
        }

        $generator->setReturnRaw(false);

        foreach (range(1, 1000) as $length) {
            $generator->setLength($length);
            $this->assertSame($length, strlen($generator->generate()));
        }
    }

    public function testGeneratorRaw()
    {
        $generator = new BytesGenerator();

        $generator->setReturnRaw(true);
        $this->assertSame(1000, strlen($generator->setLength(1000)->generate()));

        $generator->setReturnRaw(false);
        $this->assertSame(1000, strlen($generator->setLength(1000)->generate()));
    }

    public function testGeneratorLengthExceptionOnZeroParameterValue()
    {
        $generator = new BytesGenerator();

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Cannot generate random bytes with length of "0" as positive value required.');
        $generator->setLength(0);
    }

    public function testGeneratorLengthExceptionOnNegativeParameterValue()
    {
        $generator = new BytesGenerator();

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Cannot generate random bytes with length of "-10" as positive value required.');
        $generator->setLength(-10);
    }

    public function testReturnFilter()
    {
        $generator = new BytesGenerator();
        $generator->setReturnFilter(function (string $return) : int {
            return (int) preg_replace('{[^0-9]}', '', $return);
        });

        $this->assertRegExp('{[0-9]+}', $generator->generate());
    }
}

/* EOF */
