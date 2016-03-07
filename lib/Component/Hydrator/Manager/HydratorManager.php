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

namespace Scribe\Wonka\Component\Hydrator\Manager;

use Scribe\Wonka\Component\Hydrator\Mapping\HydratorMapping;
use Scribe\Wonka\Component\Hydrator\Mapping\HydratorMappingInterface;
use Scribe\Wonka\Exception\InvalidArgumentException;
use Scribe\Wonka\Utility\Reflection\ClassReflectionAnalyser;

/**
 * Class HydratorManager.
 */
class HydratorManager implements HydratorManagerInterface
{
    /**
     * @var \Scribe\Wonka\Component\Hydrator\Mapping\HydratorMappingInterface
     */
    protected $mapping;

    /**
     * Object can be instantiated with the mapping definition directly.
     *
     * @param \Scribe\Wonka\Component\Hydrator\Mapping\HydratorMappingInterface $mapping
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
     * @param \Scribe\Wonka\Component\Hydrator\Mapping\HydratorMappingInterface|null $mapping
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
