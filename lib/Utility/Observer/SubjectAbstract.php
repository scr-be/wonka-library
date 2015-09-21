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
 * Class Subject.
 */
class SubjectAbstract implements SplSubject
{
    /**
     * @var array
     */
    protected $observers;

    /**
     * @var bool
     */
    protected $notify;

    /**
     * @param $observers array
     */
    public function __construct(array $observers = [])
    {
        $this->notify = true;
        $this->observers = array_filter($observers, [$this, 'isObserver']);
    }

    public function setNotify($notify = true)
    {
        $this->notify = (bool) $notify;
    }

    /**
     * @return SubjectAbstract
     */
    public function notify()
    {
        foreach ($this->observers as $observer) {
            if ($this->notify === false) {
                break;
            }
            $observer->update($this);
        }

        return $this;
    }

    /**
     * @param $observer SplObserver
     *
     * @return SubjectAbstract
     */
    public function attach(SplObserver $observer)
    {
        $this->observers[] = $observer;

        return $this;
    }

    /**
     * @param $observer SplObserver
     *
     * @return SubjectAbstract
     */
    public function detach(SplObserver $observer)
    {
        if (in_array($observer, $this->observers)) {
            $diff = array_diff($this->observers, [$observer]);
        }

        return $this;
    }

    /**
     * @return $this
     */
    public function detachAll()
    {
        $this->observers = [];

        return $this;
    }

    /**
     * @param $observer SplObserver
     *
     * @return bool
     */
    public function has(SplObserver $observer)
    {
        if (in_array($observer, $this->observers)) {
            return true;
        }

        return false;
    }

    /**
     * @param $observer mixed
     *
     * @return bool
     */
    protected function isObserver($observer)
    {
        if ($observer instanceof SplObserver) {
            return true;
        }

        return false;
    }
}

/* EOF */
