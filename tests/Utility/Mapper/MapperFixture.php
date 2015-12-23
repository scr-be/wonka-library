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

namespace Scribe\Wonka\Tests\Utility\Mapper;

use Scribe\Wonka\Utility\Mapper\ParametersToPropertiesMapperTrait;

/**
 * Class MapperFixture.
 */
class MapperFixture
{
    use ParametersToPropertiesMapperTrait;

    /**
     * @var string
     */
    private $propertyString;

    /**
     * @var int
     */
    private $propertyInt;

    /**
     * @var array
     */
    private $propertyArray;

    /**
     * @var callable
     */
    private $propertyCallable;

    /**
     * @param array[] ...$parameters
     */
    public function __construct(...$parameters)
    {
        $this->assignPropertyCollectionToSelf(...$parameters);
    }

    /**
     * @param array[] ...$parameters
     */
    public function exposeAssignPropertyCollectionToSelf(...$parameters)
    {
        $this->assignPropertyCollectionToSelf(...$parameters);
    }

    public function exposeGetObjectVars()
    {
        return get_object_vars($this);
    }

    public function exposeFilterPropertyAssignmentsForSelf(array $assignmentCollection)
    {
        $this->filterPropertyAssignmentsForSelf($assignmentCollection, get_object_vars($this));
    }

    public function exposeNormalizeCollectionParametersForSelf(array $parameterCollection)
    {
        return $this->normalizeCollectionParametersForSelf($parameterCollection, null);
    }

    public function exposeAssignPropertyToSelf($propertyName, $propertyValue)
    {
        $this->assignPropertyToSelf($propertyName, $propertyValue);
    }

    /**
     * @return string
     */
    public function getPropertyString()
    {
        return $this->propertyString;
    }

    /**
     * @param string $propertyString
     */
    public function setPropertyString($propertyString)
    {
        $this->propertyString = $propertyString;
    }

    /**
     * @return int
     */
    public function getPropertyInt()
    {
        return $this->propertyInt;
    }

    /**
     * @param int $propertyInt
     */
    public function setPropertyInt($propertyInt)
    {
        $this->propertyInt = $propertyInt;
    }

    /**
     * @return array
     */
    public function getPropertyArray()
    {
        return $this->propertyArray;
    }

    /**
     * @param array $propertyArray
     */
    public function setPropertyArray(array $propertyArray)
    {
        $this->propertyArray = $propertyArray;
    }

    /**
     * @return callable
     */
    public function getPropertyCallable()
    {
        return $this->propertyCallable;
    }

    /**
     * @param callable $propertyCallable
     */
    public function setPropertyCallable(callable $propertyCallable)
    {
        $this->propertyCallable = $propertyCallable;
    }
}

/* EOF */
