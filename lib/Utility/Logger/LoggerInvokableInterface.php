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

use Psr\Log\LoggerInterface;

/**
 * Interface LoggerInvokableInterface.
 */
interface LoggerInvokableInterface
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
     *
     * @return null
     */
    public function __invoke($message, $level = null, array $context = []);
}

/* EOF */
