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

namespace Scribe\Wonka\Utility\Logger;

use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerInterface;

/**
 * Class LoggerInvokable.
 */
class LoggerInvokable implements LoggerAwareInterface, LoggerInvokableInterface, LevelsAwareInterface
{
    use LoggerAwareTrait;
    use LevelsAwareTrait;

    /**
     * @param LoggerInterface $logger
     * @param string|null     $levelDefault
     */
    public function __construct(LoggerInterface $logger, $levelDefault = null)
    {
        $this->setLogger($logger);
        $this->setLevelDefault($levelDefault);
    }

    /**
     * @param string      $message
     * @param null|string $level
     * @param mixed[]     $context
     *
     * @return $this
     */
    public function __invoke($message, $level = null, array $context = [])
    {
        $this->logger->log($this->getLevelValidated($level), $message, $context);

        return $this;
    }
}

/* EOF */
