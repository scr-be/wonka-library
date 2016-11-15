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

namespace SR\Wonka\Tests\Utility\Logger;

use Monolog\Logger;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;
use SR\Wonka\Utility\Logger\InvokableLogger;
use SR\Wonka\Utility\UnitTest\WonkaTestCase;

/**
 * Class LoggerInvokableTest.
 *
 * @skip
 */
class LoggerInvokableTest extends WonkaTestCase
{
    /**
     * @return InvokableLogger
     */
    public function mockInvokable(LoggerInterface $logger, $levelDefault = null)
    {
        return $this
            ->getMockBuilder('SR\Wonka\Utility\Logger\InvokableLogger')
            ->setConstructorArgs([$logger, $levelDefault])
            ->setMethods(null)
            ->getMock();
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|NullLogger
     */
    public function mockLogger()
    {
        return $this
            ->getMockBuilder('Psr\Log\NullLogger')
            ->setMethods(['log'])
            ->getMock();
    }

    public function testGetterAndSetterMethodsCallable()
    {
        $logger = $this->mockLogger();
        $invokable = $this->mockInvokable($logger);

        static::assertNotNull($invokable->getLogger());
        static::assertNotNull($invokable->getLogDefaultLevel());
        static::assertSame(InvokableLogger::LOG_LEVEL_DEFAULT, $invokable->getLogDefaultLevel());

        $invokable->setLogDefaultLevel(InvokableLogger::LOG_LEVEL_ALERT);

        static::assertSame(InvokableLogger::LOG_LEVEL_ALERT, $invokable->getLogDefaultLevel());

        $invokable('A message for the logger!');
    }
}

/* EOF */
