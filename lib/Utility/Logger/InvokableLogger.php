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

namespace SR\Wonka\Utility\Logger;

use Psr\Log\LoggerInterface;
use SR\Exception\Logic\InvalidArgumentException;
use SR\Log\LoggerAwareInterface;
use SR\Log\LoggerAwareTrait;

/**
 * Class InvokableLogger.
 */
class InvokableLogger implements LoggerAwareInterface, InvokableLoggerInterface, LevelsAwareInterface
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
        $this->setLogDefaultLevel($levelDefault);
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
        if (is_null($level)) {
            $level = $this->getLogDefaultLevel();
        }

        $method = sprintf('log%s', ucfirst(strtolower($level)));

        call_user_func_array([$this, $method], [
            $message,
            $context,
        ]);

        return $this;
    }
}

/* EOF */
