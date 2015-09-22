<?php

/*
 * This file is part of the scribe/wonka-bundle.
 *
 * (c) Scribe Inc. <rmf@scr.be>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\Wonka\Tests\Component\Hydrator\Mapping;

use Scribe\Wonka\Component\Hydrator\Mapping\HydratorMapping;
use Scribe\Wonka\Tests\Component\Hydrator\HydratorMockObjectInstance;
use Scribe\Wonka\Utility\UnitTest\WonkaTestCase;

/**
 * Class HydratorMappingTest.
 */
class HydratorMappingTest extends WonkaTestCase
{
    /**
     * @var \stdClass
     */
    public $from;

    public function setUp()
    {
        parent::setUp();

        $this->from = new HydratorMockObjectInstance();
    }

    public function testConstructorUsage()
    {
        $def = new HydratorMapping(false, [
            'doesnt-exist' => null,
            'publicProp' => 'renamed0',
            'protectedProp' => 'renamed1',
        ]);

        $expected = [
            'publicProp' => 'renamed0',
            'protectedProp' => 'renamed1',
        ];

        static::assertEquals($expected, $def->getTransferable($this->from));
    }

    public function testVariadic()
    {
        $def = new HydratorMapping(false);
        $def
            ->setMappingFrom('doesnt-exist', 'random_public_prop', 'privateProp', 'protectedProp')
            ->setMappingTo('doesnt-exist', 'privateProp', 'protectedProp', 'random_public_prop')
        ;

        $expected = [
            'random_public_prop' => 'privateProp',
            'privateProp' => 'protectedProp',
            'protectedProp' => 'random_public_prop'
        ];

        static::assertEquals($expected, $def->getTransferable($this->from));
    }

    public function testEmptyTo()
    {
        $def = new HydratorMapping(false);
        $def
            ->setMappingFrom('random_public_prop', 'privateProp', 'protectedProp')
            ->setMappingTo()
        ;

        $expected = [
            'random_public_prop' => 'random_public_prop',
            'privateProp' => 'privateProp',
            'protectedProp' => 'protectedProp'
        ];

        static::assertEquals($expected, $def->getTransferable($this->from));
    }

    public function testInvalidObject()
    {
        $def = new HydratorMapping(false);

        static::assertEquals([], $def->getTransferable('not-an-object'));
    }

    public function testNoProperties()
    {
        $def = new HydratorMapping(false);
        $def
            ->setMappingFrom('doesnt-exist', 'parentNode', 'childNodes', 'childNodes')
            ->setMappingTo()
        ;

        static::assertEquals([], $def->getTransferable(new \stdClass()));
    }

    public function testGreedy()
    {
        $def = new HydratorMapping();
        $def
            ->setMappingFrom('doesnt-exist', 'protectedProp', 'publicProp', 'invalid-property')
            ->setMappingTo('doesnt-exist', 'privateProp', 'protectedProp', 'should-be-ignored')
        ;

        $expected = [
            'publicProp' => 'protectedProp',
            'random_public_prop' => 'random_public_prop',
            'protectedProp' => 'privateProp',
            'random_protected_prop' => 'random_protected_prop',
            'privateProp' => 'privateProp',
            'random_private_prop' => 'random_private_prop',
        ];

        static::assertEquals($expected, $def->getTransferable($this->from));
    }
}
