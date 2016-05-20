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

namespace SR\Wonka\Utility\Mapper;

use SR\Utility\ArrayInspect;

/**
 * Trait MagicPropertyMapperAwareTrait.
 *
 * Allows for quick mapping of any indexed or hashed array of values to properties within a class.
 */
trait ParametersToPropertiesMapperTrait
{
    /**
     * Ingests one or more associative arrays (passed as parameters to this method---unlimited in number as method
     * definition is variadic---and maps them to properties of an object utalizing this trait. The format of the
     * associative arrays must be ['propertyNameFoo' => 'propertyValueFoo', 'propertyNameBar' => 'propertyValueBar, ...]
     * where the index is a string whos name directly maps to a object property.
     *
     * Do note that any array keys that exist in multiple method parameter arrays will be overridden by the last
     * definition of that key value.
     *
     * @param array[] $parameterCollection
     *
     * @return $this
     */
    protected function assignPropertyCollectionToSelf(array ...$parameterCollection)
    {
        if (0 === count($parameterCollection)) {
            return $this;
        }

        $assignmentCollection = (array) $this->normalizeCollectionParametersForSelf(
            $parameterCollection,
            [$this, 'filterPropertyAssignmentsForSelf']
        );

        if (0 === count($assignmentCollection)) {
            return $this;
        }

        foreach ($assignmentCollection as $propertyName => $propertyValue) {
            $this->assignPropertyToSelf($propertyName, $propertyValue);
        }

        return $this;
    }

    /**
     * Filters the passed associative array (using the index as the property) so it only contains assignments to defined
     * properties within the current object context.
     *
     * @internal
     *
     * @param array[]  $assignmentCollection
     * @param string[] $objectPropertyCollection
     *
     * @return array
     */
    final private function filterPropertyAssignmentsForSelf(array $assignmentCollection, array $objectPropertyCollection = [])
    {
        if (false === ArrayInspect::isAssociative($assignmentCollection)) {
            return [];
        }

        return (array) array_filter($assignmentCollection, function ($propertyName) use ($objectPropertyCollection) {
            return (bool) array_key_exists($propertyName, $objectPropertyCollection);
        }, ARRAY_FILTER_USE_KEY);
    }

    /**
     * Given a multi-dimensional array who's first-level is a simple index-based array with values consisting of
     * associative arrays intended to act as instructions for assigning properties or calling functions based on the
     * associative array index and values intended to act as the value for the assignment or parameter(s) to the function,
     * this method merges the first level down to a single associative array. Passing the optional callable allows for
     * action to be taken on the associative array prior to merger and should accept an array as its sole parameter and
     * return an array as a result of whatever actions it may perform.
     *
     * @internal
     *
     * @param array[]                $parameterCollection
     * @param \Closure|callable|null $assignmentCollectionFilter
     *
     * @return array
     */
    final private function normalizeCollectionParametersForSelf(array $parameterCollection, callable $assignmentCollectionFilter = null)
    {
        if (false === is_callable($assignmentCollectionFilter)) {
            $assignmentCollectionFilter = function (array $assignmentCollection) {
                return $assignmentCollection;
            };
        }

        $assignmentCollectionMerged = [];
        $objectPropertyCollection = get_object_vars($this);

        foreach ($parameterCollection as $assignmentCollection) {
            $assignmentCollectionMerged = array_merge(
                (array) $assignmentCollectionMerged,
                (array) $assignmentCollectionFilter($assignmentCollection, $objectPropertyCollection)
            );
        }

        return (array) $assignmentCollectionMerged;
    }

    /**
     * Attempts to assign a variable property the passed value.
     *
     * @internal
     *
     * @param string $property
     * @param mixed  $value
     *
     * @return $this
     */
    final private function assignPropertyToSelf($property, $value)
    {
        $this->$property = $value;

        return $this;
    }
}

/* EOF */
