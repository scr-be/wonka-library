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

/**
 * Interface InvokableLoggerInterface.
 */
interface InvokableLoggerInterface
{
    /**
     * @param LoggerInterface $logger
     * @param string|null     $levelDefault
     */
    public function __construct(LoggerInterface $logger, $levelDefault = null);

    /**
     * @param string      $message
     * @param null|string $level
     * @param mixed[]     $context
     */
    public function __invoke($message, $level = null, array $context = []);
}

/* EOF */
