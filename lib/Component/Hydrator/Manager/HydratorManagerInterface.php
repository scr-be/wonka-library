<?php

/*
 * This file is part of the scribe/wonka-bundle.
 *
 * (c) Scribe Inc. <rmf@scr.be>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\Wonka\Component\Hydrator\Manager;

use Scribe\Wonka\Component\Hydrator\Mapping\HydratorMappingInterface;

/**
 * Class HydratorManagerInterface.
 */
interface HydratorManagerInterface
{
    /**
     * Set custom object property mapping.
     *
     * @param \Scribe\Wonka\Component\Hydrator\Mapping\HydratorMappingInterface|null $mapping
     *
     * @return $this
     */
    public function setMapping(HydratorMappingInterface $mapping = null);

    /**
     * @param object $from
     * @param object $to
     *
     * @return object
     */
    public function getMappedObject($from, $to);
}

/* EOF */
