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

namespace Scribe\Wonka\Component\Hydrator\Mapping;

use Scribe\Wonka\Utility\Reflection\ClassReflectionAnalyser;

/**
 * Class HydratorMapping.
 */
class HydratorMapping implements HydratorMappingInterface
{
    /**
     * Is the mapping greedy (iterates all properties in the original object) or constrained (only iterates over
     * the properties explicitly set via {@see setMapping()} or {@see setMappingFrom()}.
     *
     * @var bool
     */
    protected $greedy;

    /**
     * Array of key value pairs representing the mapping from new to old object. A value of null on a key
     * means it will map to the same property name.
     *
     * @var string[]
     */
    protected $mapping;

    /**
     * Sets up the initialized state of the class such that it returns a blind list of (one-to-one) of all
     * properties within the original (from) object.
     *
     * @param bool  $greedy
     * @param array $propertyCollectionMap
     */
    public function __construct($greedy = true, array $propertyCollectionMap = [])
    {
        $this->mapping = [];

        $this
            ->setGreedy($greedy)
            ->setMapping($propertyCollectionMap)
        ;
    }

    /**
     * When set to true, the {@see getTransferable()} method will return an array of all transferable properties
     * by looping through all properties on the original (from) data-object. When set to false it will return an
     * array of transferable properties constrained by the property explicitly passed via the mapping methods.
     *
     * @param bool $greedy
     *
     * @return $this
     */
    public function setGreedy($greedy = true)
    {
        $this->greedy = $greedy;

        return $this;
    }

    /**
     * Accepts a multi-dimensional array of string values where the array key represents the property in the
     * original (from) object that should be mapped to the new (to) object based on its string value.
     *
     * @param array $propertyCollectionMap
     *
     * @return $this
     */
    public function setMapping(array $propertyCollectionMap = [])
    {
        list($from, $to) = $this->getMappingSeparated($propertyCollectionMap);

        $this
            ->setMappingFrom(...$from)
            ->setMappingTo(...$to)
            ;

        return $this;
    }

    /**
     * Accepts a variable number of string arguments that represent the properties to map from the original (from)
     * object. When {@see getTransferable()} is called these properties will be mapped to the array of properties
     * set via {@see setMappingTo()} to determine the property assignment in the new object.
     *
     * @param string[] ...$propertyCollection
     *
     * @return $this
     */
    public function setMappingFrom(...$propertyCollection)
    {
        foreach ($propertyCollection as $property) {
            if (true === array_key_exists($property, $this->mapping)) {
                continue;
            }

            $this->mapping[$property] = null;
        }

        return $this;
    }

    /**
     * Accepts a variable number of string arguments that represent the properties to map to the new object in
     * correlation to the {@see setMappingFrom()} collection. Note that when {@see setGreedy()} is set to false,
     * not passing any values to this object allows {@see setMappingFrom()} to simply act as a constraint.
     *
     * @param string ...$propertyCollection
     *
     * @return $this
     */
    public function setMappingTo(...$propertyCollection)
    {
        foreach ($this->mapping as &$toProperty) {
            if (true === empty($propertyCollection)) {
                break;
            }

            $toProperty = array_shift($propertyCollection);
        }

        return $this;
    }

    /**
     * Returns an multi-dimensional array of key=>value pairs representing the property names to be transferred from
     * the original (from) object to the new (to) object. The key=>value relationship is the same as {@see setMapping()},
     * representing originalPropertyName=>newPropertyName.
     *
     * @param object $from
     *
     * @return array
     */
    public function getTransferable($from)
    {
        if (true !== is_object($from)) {
            return [];
        }

        return $this->getProperties($from);
    }

    /**
     * Returns an array of the object properties.
     *
     * @param object $objectInstance
     *
     * @return array
     */
    protected function getProperties($objectInstance)
    {
        $analyser = new ClassReflectionAnalyser();
        $analyser->setReflectionClassFromClassInstance($objectInstance);
        $refPropertyCollection = (array) $analyser->getProperties(false);

        if (0 === count($refPropertyCollection)) {
            return [];
        }

        $propertyCollection = (array) $this->getPropertiesFromRef($refPropertyCollection);
        $filteredCollection = (array) $this->getPropertiesFiltered($propertyCollection);

        return (array) $this->getPropertiesMap($filteredCollection);
    }

    protected function getPropertiesFromRef(array $refPropertyCollection)
    {
        $refPropertyCollection = array_filter($refPropertyCollection, function ($refProperty) {
            return (bool) ($refProperty instanceof \ReflectionProperty);
        });

        array_walk($refPropertyCollection, function (&$refProperty) {
            $refProperty = $refProperty->name;
        });

        return $refPropertyCollection;
    }

    /**
     * @param array $propertyCollection
     *
     * @return array
     */
    protected function getPropertiesFiltered(array $propertyCollection)
    {
        if (false === $this->greedy) {
            list($mappingFrom) = $this->getMappingSeparated($this->mapping);

            $propertyCollection = array_filter($propertyCollection, function ($property) use ($mappingFrom) {
                return (bool) (in_array($property, $mappingFrom, false) ? true : false);
            });
        }

        return $propertyCollection;
    }

    /**
     * @param array $propertyCollection
     *
     * @return array
     */
    protected function getPropertiesMap(array $propertyCollection)
    {
        list($mappingFrom, $mappingTo) = $this->getMappingSeparated($this->mapping);
        $mappedCollection = [];

        foreach ($propertyCollection as $index => $from) {
            if (false === ($key = array_search($from, $mappingFrom, false))) {
                $mappedCollection[$from] = $from;
                continue;
            }

            if (false === array_key_exists($key, $mappingTo) || null === $mappingTo[$key]) {
                $mappedCollection[$from] = $from;
                continue;
            }

            $mappedCollection[$from] = $mappingTo[$key];
        }

        return (array) $mappedCollection;
    }

    /**
     * @param array $mapping
     *
     * @return array
     */
    protected function getMappingSeparated(array $mapping)
    {
        $mappingFrom = array_keys($mapping);
        $mappingTo = array_values($mapping);

        return [
            $mappingFrom,
            $mappingTo,
        ];
    }
}

/* EOF */
