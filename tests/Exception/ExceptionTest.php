<?php

/*
 * This file is part of the `src-run/wonka-library` project.
 *
 * (c) Rob Frawley 2nd <rmf@src.run>
 * (c) Scribe Inc      <scr@src.run>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace SR\Wonka\Tests\Exception;

use SR\Wonka\Exception\BadFunctionCallException;
use SR\Wonka\Exception\Exception;
use SR\Wonka\Exception\ExceptionInterface;
use SR\Wonka\Exception\InvalidArgumentException;
use SR\Wonka\Exception\LogicException;
use SR\Wonka\Exception\RuntimeException;
use SR\Wonka\Utility\UnitTest\WonkaTestCase;

/**
 * Class ExceptionTest.
 */
class ExceptionTest extends WonkaTestCase
{
    public function testDefaults()
    {
        $e = new Exception('A %s.', 'message');
        static::assertEquals('A message.', $e->getMessage());
        static::assertEquals(ExceptionInterface::CODE_GENERIC, $e->getCode());

        $e = new Exception();
        static::assertNotNull($e->getMessage());
        static::assertNotNull($e->getCode());
    }

    public function testLogicException()
    {
        $e = new LogicException('A %s.', 'message');
        static::assertEquals('A message.', $e->getMessage());
        static::assertEquals(ExceptionInterface::CODE_GENERIC, $e->getCode());

        $e = new LogicException();
        static::assertNotNull($e->getMessage());
        static::assertNotNull($e->getCode());
    }

    public function testBadFunctionCallException()
    {
        $e = new BadFunctionCallException('A %s.', 'message');
        static::assertEquals('A message.', $e->getMessage());
        static::assertEquals(ExceptionInterface::CODE_GENERIC, $e->getCode());

        $e = new BadFunctionCallException();
        static::assertNotNull($e->getMessage());
        static::assertNotNull($e->getCode());
    }

    public function testRuntimeException()
    {
        $e = new RuntimeException('A %s.', 'message');
        static::assertEquals('A message.', $e->getMessage());

        $e = new RuntimeException();
        static::assertNotNull($e->getMessage());
        static::assertNotNull($e->getCode());
    }

    public function testInvalidArgumentException()
    {
        $e = new InvalidArgumentException('A %s.', 'message');
        static::assertEquals('A message.', $e->getMessage());

        $e = new InvalidArgumentException();
        static::assertNotNull($e->getMessage());
        static::assertNotNull($e->getCode());
    }
}

/* EOF */
