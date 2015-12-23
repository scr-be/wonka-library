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

namespace Scribe\Wonka\Tests\Component\Hydrator\Manager;

use Scribe\Wonka\Component\Hydrator\Mapping\HydratorMapping;
use Scribe\Wonka\Component\Hydrator\Manager\HydratorManager;
use Scribe\Wonka\Tests\Component\Hydrator\HydratorMockObjectInstance;
use Scribe\Wonka\Utility\UnitTest\WonkaTestCase;

/**
 * Class HydratorManagerTest.
 */
class HydratorManagerTest extends WonkaTestCase
{
    /**
     * @var HydratorMockObjectInstance
     */
    public static $objectInstanceOne;

    /**
     * @var HydratorMockObjectInstance
     */
    public static $objectInstanceTwo;

    public function setUp()
    {
        parent::setUp();

        self::$objectInstanceOne = new HydratorMockObjectInstance();
        self::$objectInstanceTwo = new HydratorMockObjectInstance();
    }

    public function testConstructorWithFixtureUsage()
    {
        $createdOn = new \DateTime();
        $updatedOn = new \DateTime();

        self::$objectInstanceOne
            ->setPublicProp('Something Else')
            ->setProtectedProp(new \Datetime())
            ->setPrivateProp(['an', 'array', 'value'])
        ;

        $def = new HydratorMapping(false, [
            'doesnt-exist' => null,
            'publicProp' => 'publicProp',
            'protectedProp' => 'protectedProp',
            'privateProp' => 'privateProp',
            'ending-bad-property' => 'wont-be-transferred',
            'another-invalid-property' => 'nothing',
        ]);

        $transferManager = new HydratorManager($def);
        $expected = self::$objectInstanceOne;
        $result = $transferManager->getMappedObject(self::$objectInstanceOne, self::$objectInstanceTwo);

        static::assertEquals($expected, $result);
    }

    public function testConstructorGreedyWithFixtureUsage()
    {
        $propOne = 1000;
        $propTwo = 'some-value';
        $propThree = [new HydratorMockObjectInstance(), new HydratorMockObjectInstance()];

        self::$objectInstanceOne
            ->setPublicProp($propOne)
            ->setProtectedProp($propTwo)
            ->setPrivateProp($propThree)
        ;

        $def1 = new HydratorMapping(true, [
            'doesnt-exist' => null,
            'publicProp' => 'random_public_prop',
            'another-invalid-property' => 'nothing',
            'protectedProp' => 'random_protected_prop',
            'privateProp' => 'random_private_prop',
        ]);
        $def2 = new HydratorMapping(true, [
            'publicProp' => 'publicProp',
            'protectedProp' => 'protectedProp',
            'privateProp' => 'privateProp',
        ]);
        $def3 = new HydratorMapping(true, [
            'random_public_prop' => 'random_public_prop',
            'random_protected_prop' => 'random_protected_prop',
            'random_private_prop' => 'random_private_prop',
        ]);

        $transferManager1 = new HydratorManager($def1);
        $transferManager2 = new HydratorManager($def2);
        $transferManager3 = new HydratorManager($def3);

        $result1 = $transferManager1->getMappedObject(self::$objectInstanceOne, self::$objectInstanceTwo);
        $result2 = $transferManager2->getMappedObject(self::$objectInstanceOne, self::$objectInstanceTwo);
        $result3 = $transferManager3->getMappedObject(self::$objectInstanceTwo, self::$objectInstanceOne);

        static::assertEquals(self::$objectInstanceOne, $result3);
        static::assertEquals(self::$objectInstanceTwo, $result3);
    }

    public function testMappingException()
    {
        $def = new HydratorMapping(true, [
            'doesnt-exist' => null,
            'author' => 'the_author',
            'another-invalid-property' => 'nothing',
            'title' => 'node_title',
            'weight' => 'node_weight',
            'created_on' => 'createdOn',
            'updated_on' => 'updatedOn',
            'ending-bad-property' => 'wont-be-transferred',
        ]);

        $this->setExpectedException(
            '\Scribe\Wonka\Exception\InvalidArgumentException',
            'The method Scribe\Wonka\Component\Hydrator\Manager\HydratorManager::getMappedObject expects to be passed two objects.'
        );

        $transferManager = new \Scribe\Wonka\Component\Hydrator\Manager\HydratorManager($def);
        $transferManager->getMappedObject(self::$objectInstanceOne, 'not-an-obj');
    }
}
