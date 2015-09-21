<?php

/*
 * This file is part of the scribe/wonka-bundle.
 *
 * (c) Scribe Inc. <rmf@scr.be>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\Wonka\Utility\Logger;

use Psr\Log\LoggerInterface;

/**
 * Interface LoggerCallableInterface.
 */
interface LoggerCallableInterface
{
    /**
     * @param LoggerInterface $logger
     */
    public function __construct(LoggerInterface $logger);

    /**
     * @param string $message
     */
    public function __invoke($message);
}

/* EOF */
