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

namespace SR\Wonka\Component\Hydrator\Manager;

use SR\Wonka\Component\Hydrator\Mapping\HydratorMappingInterface;

/**
 * Class HydratorManagerInterface.
 */
interface HydratorManagerInterface
{
    /**
     * Set custom object property mapping.
     *
     * @param \SR\Wonka\Component\Hydrator\Mapping\HydratorMappingInterface|null $mapping
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
