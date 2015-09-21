<?php

/*
 * This file is part of the scribe/wonka-bundle.
 *
 * (c) Scribe Inc. <rmf@scr.be>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\Wonka\Utility\Observer;

use SplObserver;
use SplSubject;

/**
 * Class Observer.
 */
abstract class ObserverAbstract implements SplObserver
{
    /**
     * Called when subject observer update occures.
     *
     * @param SplSubject $subject an instance of a subject
     *
     * @return $this
     */
    abstract public function update(SplSubject $subject);
}

/* EOF */
