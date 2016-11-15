<?php

/*
 * This file is part of the `src-run/wonka-library` project.
 *
 * (c) Rob Frawley 2nd <rmf@src.run>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace SR\Wonka\Utility\Reflection;

/**
 * Interface ClassReflectionAnalyserInterface.
 */
interface ClassReflectionAnalyserInterface
{
    /**
     * @param string|null $class
     *
     * @return $this
     */
    public static function create($class = null);

    /**
     * Optional injection at instantiation of reflection class for analysis.
     *
     * @param \ReflectionClass $reflectionClass
     */
    public function __construct(\ReflectionClass $reflectionClass = null);

    /**
     * Set the current reflection class to operate on (can be overridden by directly passing
     * a reflection class to any of the has[Trait|Method|Property] methods. Passing no value
     * effectively un-sets the internally held class instance.
     *
     * @param \ReflectionClass $reflectionClass
     *
     * @return $this
     */
    public function setReflectionClass(\ReflectionClass $reflectionClass = null);

    /**
     * Create and set the reflection class via a class name.
     *
     * @param string $class
     *
     * @return $this
     */
    public function setReflectionClassFromClassName($class);

    /**
     * Create and set the reflection class via a class instance.
     *
     * @param object $class
     *
     * @return $this
     */
    public function setReflectionClassFromClassInstance($class);

    /**
     * @return null|\ReflectionClass
     */
    public function getReflectionClass();

    /**
     * Un-sets the current reflection class associated with object.
     *
     * @return $this
     */
    public function unsetReflectionClass();

    /**
     * Enables ability to allow unsafe checks against trait names without passing a fully-qualified namespace.
     * Use at your own risk...
     *
     * @param bool $requireFQN
     *
     * @return $this
     */
    public function setRequireFQN($requireFQN = true);

    /**
     * Returns whether the FQN is required or not.
     *
     * @return bool
     */
    public function getRequireFQN();

    /**
     * Return true if the given object has the provided trait.
     *
     * @param string           $traitName
     * @param \ReflectionClass $class
     * @param bool             $recursiveSearch
     *
     * @return bool
     */
    public function hasTrait($traitName, \ReflectionClass $class = null, $recursiveSearch = true);

    /**
     * Returns true if the given object has the given method.
     *
     * @param string           $methodName
     * @param \ReflectionClass $class
     *
     * @return bool
     */
    public function hasMethod($methodName, \ReflectionClass $class = null);

    /**
     * Returns true if the given object has the given property.
     *
     * @param string           $propertyName
     * @param \ReflectionClass $class
     * @param bool             $recursiveSearch
     *
     * @return bool
     */
    public function hasProperty($propertyName, \ReflectionClass $class = null, $recursiveSearch = true);

    /**
     * @param int|bool $filter
     *
     * @return array
     */
    public function getProperties($filter = \ReflectionProperty::IS_PUBLIC);

    /**
     * Get an array of the class's public properties.
     *
     * @return array
     */
    public function getPropertiesPublic();

    /**
     * Get an array of the class's protected properties.
     *
     * @return array
     */
    public function getPropertiesProtected();

    /**
     * Get an array of the class's private properties.
     *
     * @return array
     */
    public function getPropertiesPrivate();

    /**
     * Set a protected/private property as public.
     *
     * @param string           $property
     * @param \ReflectionClass $class
     *
     * @return \ReflectionProperty.
     */
    public function setPropertyPublic($property, \ReflectionClass $class = null);

    /**
     * Set a protected/private method as public.
     *
     * @param string           $method
     * @param \ReflectionClass $class
     *
     * @return \ReflectionMethod.
     */
    public function setMethodPublic($method, \ReflectionClass $class = null);
}

/* EOF */
