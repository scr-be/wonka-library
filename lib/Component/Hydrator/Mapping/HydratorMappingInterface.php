<?php

/*
 * This file is part of the scribe/wonka-bundle.
 *
 * (c) Scribe Inc. <rmf@scr.be>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\Wonka\Component\Hydrator\Mapping;

/**
 * Class HydratorMappingInterface.
 */
interface HydratorMappingInterface
{
    /**
     * When set to true, the {@see getTransferable()} method will return an array of all transferable properties
     * by looping through all properties on the original (from) data-object. When set to false it will return an
     * array of transferable properties constrained by the property explicitly passed via the mapping methods.
     *
     * @param bool $greedy
     *
     * @return $this
     */
    public function setGreedy($greedy = true);

    /**
     * Accepts a multi-dimensional array of string values where the array key represents the property in the
     * original (from) object that should be mapped to the new (to) object based on its string value.
     *
     * @param array $propertyCollectionMap
     *
     * @return $this
     */
    public function setMapping(array $propertyCollectionMap = []);

    /**
     * Accepts a variable number of string arguments that represent the properties to map from the original (from)
     * object. When {@see getTransferable()} is called these properties will be mapped to the array of properties
     * set via {@see setMappingTo()} to determine the property assignment in the new object.
     *
     * @param string, ...$propertyCollection
     *
     * @return mixed
     */
    public function setMappingFrom(...$propertyCollection);

    /**
     * Accepts a variable number of string arguments that represent the properties to map to the new object in
     * correlation to the {@see setMappingFrom()} collection. Note that when {@see setGreedy()} is set to false,
     * not passing any values to this object allows {@see setMappingFrom()} to simply act as a constraint.
     *
     * @param string,... $propertyCollection
     *
     * @return mixed
     */
    public function setMappingTo(...$propertyCollection);

    /**
     * Returns an multi-dimensional array of key=>value pairs representing the property names to be transferred from
     * the original (from) object to the new (to) object. The key=>value relationship is the same as {@see setMapping()},
     * representing originalPropertyName=>newPropertyName.
     *
     * @param object $from
     *
     * @return mixed
     */
    public function getTransferable($from);
}

/* EOF */
