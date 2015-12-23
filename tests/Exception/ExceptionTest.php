<?php

/*
 * This file is part of the Wonka Library.
 *
 * (c) Scribe Inc.     <oss@src.run>
 * (c) Rob Frawley 2nd <rmf@src.run>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\Wonka\Tests\Exception;

use Scribe\Wonka\Exception\BadFunctionCallException;
use Scribe\Wonka\Exception\Exception;
use Scribe\Wonka\Exception\InvalidArgumentException;
use Scribe\Wonka\Exception\LogicException;
use Scribe\Wonka\Exception\RuntimeException;
use Scribe\Wonka\Utility\UnitTest\WonkaTestCase;

/**
 * Class ExceptionTest.
 */
class ExceptionTest extends WonkaTestCase
{
    public function testDefaults()
    {
        $e = new Exception('A %s.', 100, null, 'message');
        static::assertEquals('A message.', $e->getMessage());
        static::assertEquals(100, $e->getCode());

        $e = new Exception();
        static::assertNotNull($e->getMessage());
        static::assertNotNull($e->getCode());
    }

    public function testLogicException()
    {
        $e = new LogicException('A %s.', 100, null, 'message');
        static::assertEquals('A message.', $e->getMessage());
        static::assertEquals(100, $e->getCode());

        $e = new LogicException();
        static::assertNotNull($e->getMessage());
        static::assertNotNull($e->getCode());
    }

    public function testBadFunctionCallException()
    {
        $e = new BadFunctionCallException('A %s.', 100, null, 'message');
        static::assertEquals('A message.', $e->getMessage());
        static::assertEquals(100, $e->getCode());

        $e = new BadFunctionCallException();
        static::assertNotNull($e->getMessage());
        static::assertNotNull($e->getCode());
    }

    public function testRuntimeException()
    {
        $e = new RuntimeException('A %s.', 100, null, 'message');
        static::assertEquals('A message.', $e->getMessage());
        static::assertEquals(100, $e->getCode());

        $e = new RuntimeException();
        static::assertNotNull($e->getMessage());
        static::assertNotNull($e->getCode());
    }

    public function testInvalidArgumentException()
    {
        $e = new InvalidArgumentException('A %s.', 100, null, 'message');
        static::assertEquals('A message.', $e->getMessage());
        static::assertEquals(100, $e->getCode());

        $e = new InvalidArgumentException();
        static::assertNotNull($e->getMessage());
        static::assertNotNull($e->getCode());
    }
}

/* EOF */
