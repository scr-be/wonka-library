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

use SR\Exception\InvalidArgumentException;
use SR\Wonka\Component\Hydrator\Mapping\HydratorMapping;
use SR\Wonka\Component\Hydrator\Mapping\HydratorMappingInterface;
use SR\Wonka\Utility\Reflection\ClassReflectionAnalyser;

/**
 * Class HydratorManager.
 */
class HydratorManager implements HydratorManagerInterface
{
    /**
     * @var HydratorMappingInterface
     */
    protected $mapping;

    /**
     * Object can be instantiated with the mapping definition directly.
     *
     * @param HydratorMappingInterface $mapping
     */
    public function __construct(HydratorMappingInterface $mapping = null)
    {
        $this->setMapping(
            (null === $mapping ? new HydratorMapping() : $mapping)
        );
    }

    /**
     * Set custom object property mapping.
     *
     * @param HydratorMappingInterface|null $mapping
     *
     * @return $this
     */
    public function setMapping(HydratorMappingInterface $mapping = null)
    {
        $this->mapping = $mapping;

        return $this;
    }

    /**
     * @param object $from
     * @param object $to
     *
     * @throws \Exception If $from or $to is not an object instance.
     *
     * @return object
     */
    public function getMappedObject($from, $to)
    {
        if (false === is_object($from) || false === is_object($to)) {
            throw new InvalidArgumentException('The method %s expects to be passed two objects.', __METHOD__);
        }

        return $this->mapPropertyCollection(
            $from,
            $to,
            $this->mapping->getTransferable($from)
        );
    }

    /**
     * @param object $from
     * @param object $to
     * @param array  $propertyCollection
     *
     * @return object
     */
    protected function mapPropertyCollection($from, $to, array $propertyCollection)
    {
        $refFrom = (new ClassReflectionAnalyser())
            ->setReflectionClassFromClassInstance($from);

        $refTo = (new ClassReflectionAnalyser())
            ->setReflectionClassFromClassInstance($to);

        foreach ($propertyCollection as $fromProperty => $toProperty) {
            $this->mapProperty($refFrom, $refTo, $to, $from, $fromProperty, $toProperty);
        }

        return $to;
    }

    /**
     * @param ClassReflectionAnalyser $refFrom
     * @param ClassReflectionAnalyser $refTo
     * @param object                  $to
     * @param object                  $from
     * @param string                  $fromProperty
     * @param string                  $toProperty
     */
    protected function mapProperty(ClassReflectionAnalyser $refFrom, ClassReflectionAnalyser $refTo,
                                   &$to, $from, $fromProperty, $toProperty)
    {
        if (true !== $refFrom->hasProperty($fromProperty) ||
            true !== $refTo->hasProperty($toProperty)) {
            return null;
        }

        $refFromProperty = $refFrom->setPropertyPublic($fromProperty);
        $refFromValue = $refFromProperty->getValue($from);
        $refToProperty = $refTo->setPropertyPublic($toProperty);
        $refToProperty->setValue($to, $refFromValue);
    }
}

/* EOF */
