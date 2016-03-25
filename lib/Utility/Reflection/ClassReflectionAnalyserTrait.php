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

namespace SR\Wonka\Utility\Reflection;

use SR\Wonka\Exception\InvalidArgumentException;
use SR\Wonka\Utility\ClassInfo;

/**
 * Class ClassReflectionAnalyserTrait.
 */
trait ClassReflectionAnalyserTrait
{
    /**
     * An instance of a reflection object, can be used instead of passing it manually to the
     * has[Trait|Method|Property] methods.
     *
     * @var \ReflectionClass|null
     */
    private $reflectionClass = null;

    /**
     * Enable "kind" mode with regard to trait look-ups. For example, it will blindly assume that if you want
     * to check against "SomeTrait" and it has "Some/Namespace/To/SomeTrait" that your check is valid. This is
     * generally unsafe!
     *
     * @var bool
     */
    private $requireFQN = true;

    /**
     * Set the current reflection class to operate on (can be overridden by directly passing
     * a reflection class to any of the has[Trait|Method|Property] methods.
     *
     * @param \ReflectionClass $reflectionClass
     *
     * @return $this
     */
    public function setReflectionClass(\ReflectionClass $reflectionClass = null)
    {
        $this->reflectionClass = $reflectionClass;

        return $this;
    }

    /**
     * Create and set the reflection class via a class name.
     *
     * @param string $class
     *
     * @return $this
     */
    public function setReflectionClassFromClassName($class)
    {
        $this->reflectionClass = new \ReflectionClass($class);

        return $this;
    }

    /**
     * Create and set the reflection class via a class instance.
     *
     * @param object $class
     *
     * @return $this
     */
    public function setReflectionClassFromClassInstance($class)
    {
        $this->reflectionClass = new \ReflectionClass($class);

        return $this;
    }

    /**
     * @return null|\ReflectionClass
     */
    public function getReflectionClass()
    {
        return $this->reflectionClass;
    }

    /**
     * Unsets the current reflection class associated with object.
     *
     * @return $this
     */
    public function unsetReflectionClass()
    {
        $this->reflectionClass = null;

        return $this;
    }

    /**
     * Enables ability to allow unsafe checks against trait names without passing a fully-qualified namespace.
     * Use at your own risk...
     *
     * @param bool $requireFQN
     *
     * @return $this
     */
    public function setRequireFQN($requireFQN = true)
    {
        $this->requireFQN = (bool) $requireFQN;
    }

    /**
     * Returns whether the FQN is required or not.
     *
     * @return bool
     */
    public function getRequireFQN()
    {
        return (bool) $this->requireFQN;
    }

    /**
     * Return true if the given object has the provided trait.
     *
     * @param string           $traitName
     * @param \ReflectionClass $class
     * @param bool             $recursiveSearch
     *
     * @return bool
     */
    public function hasTrait($traitName, \ReflectionClass $class = null, $recursiveSearch = true)
    {
        $class = $this->triggerUpdateWorkUnit($class);

        if (true === in_array($traitName, $this->getTraitNames($class))) {
            return true;
        }

        $parentClass = $class->getParentClass();

        if ((false === $recursiveSearch) || (false === ($parentClass instanceof \ReflectionClass))) {
            return false;
        }

        return (bool) $this->hasTrait($traitName, $parentClass, $recursiveSearch);
    }

    /**
     * Returns true if the given object has the given method.
     *
     * @param string           $methodName
     * @param \ReflectionClass $class
     *
     * @return bool
     */
    public function hasMethod($methodName, \ReflectionClass $class = null)
    {
        $class = $this->triggerUpdateWorkUnit($class);

        if (true === $class->hasMethod($methodName)) {
            return true;
        }

        return false;
    }

    /**
     * Returns true if the given object has the given property.
     *
     * @param string           $propertyName
     * @param \ReflectionClass $class
     * @param bool             $recursiveSearch
     *
     * @return bool
     */
    public function hasProperty($propertyName, \ReflectionClass $class = null, $recursiveSearch = true)
    {
        $class = $this->triggerUpdateWorkUnit($class);

        if (true === $class->hasProperty($propertyName)) {
            return true;
        }

        $parentClass = $class->getParentClass();

        if (false === $recursiveSearch || (false === ($parentClass instanceof \ReflectionClass))) {
            return false;
        }

        return (bool) $this->hasProperty($propertyName, $parentClass, $recursiveSearch);
    }

    /**
     * @param int|bool $filter
     *
     * @throws InvalidArgumentException If argument type is not false or a \ReflectionProperty filter.
     *
     * @return \ReflectionProperty[]
     */
    public function getProperties($filter = \ReflectionProperty::IS_PUBLIC)
    {
        if ($filter === false) {
            return (array) $this
                ->reflectionClass
                ->getProperties(\ReflectionProperty::IS_PUBLIC | \ReflectionProperty::IS_PROTECTED | \ReflectionProperty::IS_PRIVATE);
        }

        if ($filter === \ReflectionProperty::IS_PRIVATE) {
            return $this->getPropertiesPrivate();
        } elseif ($filter === \ReflectionProperty::IS_PROTECTED) {
            return $this->getPropertiesProtected();
        } elseif ($filter === \ReflectionProperty::IS_PUBLIC) {
            return $this->getPropertiesPublic();
        }

        throw new InvalidArgumentException('Invalid filter provided to getProperties. Valid filters are false (for all properties), '.
            '\ReflectionProperty::IS_PRIVATE \ReflectionProperty::IS_PROTECTED, and \ReflectionProperty::IS_PUBLIC.');
    }

    /**
     * Get an array of the class's public properties.
     *
     * @return array
     */
    public function getPropertiesPublic()
    {
        return (array) $this
            ->reflectionClass
            ->getProperties(\ReflectionProperty::IS_PUBLIC);
    }

    /**
     * Get an array of the class's protected properties.
     *
     * @return array
     */
    public function getPropertiesProtected()
    {
        return (array) $this
            ->reflectionClass
            ->getProperties(\ReflectionProperty::IS_PROTECTED);
    }

    /**
     * Get an array of the class's private properties.
     *
     * @return array
     */
    public function getPropertiesPrivate()
    {
        return (array) $this
            ->reflectionClass
            ->getProperties(\ReflectionProperty::IS_PRIVATE);
    }

    /**
     * Set a protected/private property as public.
     *
     * @param string           $property
     * @param \ReflectionClass $class
     *
     * @return \ReflectionProperty.
     */
    public function setPropertyPublic($property, \ReflectionClass $class = null)
    {
        $class = $this->triggerUpdateWorkUnit($class);
        $className = $class->getName();

        if (false === $this->hasProperty($property)) {
            throw new InvalidArgumentException('The requested property %s does not exist on the passed class %s.',
                $property, $className);
        }

        $classProperty = $class->getProperty($property);
        $classProperty->setAccessible(true);

        return $classProperty;
    }

    /**
     * Set a protected/private method as public.
     *
     * @param string           $method
     * @param \ReflectionClass $class
     *
     * @return \ReflectionMethod.
     */
    public function setMethodPublic($method, \ReflectionClass $class = null)
    {
        $class = $this->triggerUpdateWorkUnit($class);
        $className = $class->getName();

        if (false === $this->hasMethod($method)) {
            throw new InvalidArgumentException('The requested method %s does not exist on the passed class %s.',
                $method, $className);
        }

        $classMethod = $class->getMethod($method);
        $classMethod->setAccessible(true);

        return $classMethod;
    }

    /**
     * Returns either the explicitly provided reflection instance, the class-set reflection instance, or null.
     *
     * @param \ReflectionClass|null $reflectionClass
     *
     * @return \ReflectionClass|null
     */
    private function triggerUpdateWorkUnit(\ReflectionClass $reflectionClass = null)
    {
        if ($reflectionClass instanceof \ReflectionClass) {
            return $reflectionClass;
        }

        if ($this->reflectionClass instanceof \ReflectionClass) {
            return $this->reflectionClass;
        }

        throw new InvalidArgumentException('No valid object reflection class instance provided explicitly via method call or injected into object instance.');
    }

    /**
     * Return the trait names of the provided reflection class. Optionally returns an array containing both the
     * fully-qualified names as well as the stand-alone trait names. Be cautious when using this option.
     *
     * @param \ReflectionClass $reflectionClass
     *
     * @return array
     */
    private function getTraitNames(\ReflectionClass $reflectionClass)
    {
        $traits = $reflectionClass->getTraitNames();

        if (false === (count($traits) > 0)) {
            return [];
        }

        if (true === $this->requireFQN) {
            return (array) $traits;
        }

        return (array) array_merge(
            $traits,
            $this->getTraitNamesUnqualified($traits)
        );
    }

    /**
     * Translate fully-qualified trait paths into their unqualified trait name.
     *
     * @param array $traits
     *
     * @return array
     */
    private function getTraitNamesUnqualified(array $traits)
    {
        array_walk($traits, function (&$t) {
            $t = ClassInfo::getTraitName($t);
        });

        return (array) $traits;
    }
}

/* EOF */
