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

namespace Scribe\Wonka\Tests\Utility\Logger;

use Monolog\Logger;
use Psr\Log\LoggerInterface;
use Scribe\Wonka\Utility\Logger\InvokableLogger;
use Scribe\Wonka\Utility\UnitTest\WonkaTestCase;

/**
 * Class LoggerInvokableTest.
 */
class LoggerInvokableTest extends WonkaTestCase
{
    /**
     * @return InvokableLogger
     */
    public function mockInvokable(LoggerInterface $logger, $levelDefault = null)
    {
        return $this
            ->getMockBuilder('Scribe\Wonka\Utility\Logger\InvokableLogger')
            ->setConstructorArgs([$logger, $levelDefault])
            ->setMethods(null)
            ->getMock();
    }

    /**
     * @return Logger
     */
    public function mockLogger()
    {
        return $this
            ->getMockBuilder('Monolog\Logger')
            ->setConstructorArgs(['phpunit'])
            ->setMethods(['log'])
            ->getMock();
    }

    public function testGetterAndSetterMethodsCallable()
    {
        $logger = $this->mockLogger();
        $logger->expects($this->atLeastOnce())->method('log');
        $invokable = $this->mockInvokable($logger);

        static::assertNotNull($invokable->getLogger());
        static::assertNotNull($invokable->getLevelDefault());
        static::assertSame(InvokableLogger::HARD_DEFAULT, $invokable->getLevelDefault());

        $invokable->setLevelDefault(InvokableLogger::ALERT);

        static::assertSame(InvokableLogger::ALERT, $invokable->getLevelDefault());

        $invokable('A message for the logger!');
    }
}

/* EOF */
