<?php

/*
 * This file is part of the `src-run/wonka-library` project.
 *
 * (c) Rob Frawley 2nd <rmf@src.run>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace SR\Wonka\Tests\Utility\System;

use SR\Wonka\Tests\Utility\Mapper\MapperFixture;
use SR\Wonka\Utility\UnitTest\WonkaTestCase;

class ParametersToPropertiesMapperTraitTest extends WonkaTestCase
{
    public function testAssignmentMapping()
    {
        $propertyString[] = 'some-random-string-value';
        $propertyInt[] = 1023;
        $propertyArray[] = ['some', 'random', 'array', 'values'];
        $propertyCallable[] = [function () {
        }];
        $propertyDoesNotExist[] = 'not-a-valid-property';

        $propertyString[] = 'another-random-string';
        $propertyInt[] = 2222;
        $propertyArray[] = ['more' => ['complex', 'array'], 'with-callable' => function () {
            return true;
        }, 'and-integers' => [1, 2, 3, 4], 'and-more', 'oh-my!'];
        $propertyCallable[] = [function ($param1, $param2) {
            return $param1.$param2;
        }];
        $propertyDoesNotExist[] = ['this', 'is', 'not', 'a', 'valid', 'property'];

        $loopCount = count($propertyString);

        for ($i = 0; $i < $loopCount; ++$i) {
            $mapper = new MapperFixture(
                [
                    'propertyString' => $propertyString[$i],
                    'propertyInt' => $propertyInt[$i],
                    'propertyDoesNotExist' => $propertyDoesNotExist[$i],
                ],
                [
                    'propertyArray' => $propertyArray[$i],
                    'propertyCallable' => $propertyCallable[$i],
                ]
            );

            static::assertEquals(4, count($mapper->exposeGetObjectVars()));
            static::assertEquals($propertyString[$i], $mapper->getPropertyString());
            static::assertEquals($propertyInt[$i], $mapper->getPropertyInt());
            static::assertEquals($propertyArray[$i], $mapper->getPropertyArray());
            static::assertEquals($propertyCallable[$i], $mapper->getPropertyCallable());
        }
    }

    public function testNoAssignments()
    {
        $mapper = new MapperFixture();

        static::assertEquals(4, count($mapper->exposeGetObjectVars()));
        static::assertNull($mapper->getPropertyString());
        static::assertNull($mapper->getPropertyInt());
        static::assertNull($mapper->getPropertyArray());
        static::assertNull($mapper->getPropertyCallable());
    }

    public function testNoValidAssignmentsAssignments()
    {
        $mapper = new MapperFixture(
            [
                'not-valid' => 'nope',
                'another-invalid-property' => function () {
                },
            ],
            [
                'last-invalid-assignment' => 12,
            ]
        );

        static::assertEquals(4, count($mapper->exposeGetObjectVars()));
        static::assertNull($mapper->getPropertyString());
        static::assertNull($mapper->getPropertyInt());
        static::assertNull($mapper->getPropertyArray());
        static::assertNull($mapper->getPropertyCallable());
    }

    public function testPropertyAssignmentIsNotHash()
    {
        $mapper = new MapperFixture();
        $mapper->exposeFilterPropertyAssignmentsForSelf(['an', 'array', 'that', 'is', 'not', 'a', 'hash']);

        static::assertEquals(4, count($mapper->exposeGetObjectVars()));
        static::assertNull($mapper->getPropertyString());
        static::assertNull($mapper->getPropertyInt());
        static::assertNull($mapper->getPropertyArray());
        static::assertNull($mapper->getPropertyCallable());
    }

    public function testPropertyAssignmentNoFilterAndExpectedException()
    {
        $parameters = [
            [
                'not-valid' => 'nope',
                'another-invalid-property' => function () {
                },
                'last-invalid-assignment' => 12,
                'propertyString' => 'a-string',
            ],
        ];

        $mapper = new MapperFixture(...$parameters);

        static::assertEquals(4, count($mapper->exposeGetObjectVars()));
        static::assertEquals('a-string', $mapper->getPropertyString());
        static::assertNull($mapper->getPropertyInt());
        static::assertNull($mapper->getPropertyArray());
        static::assertNull($mapper->getPropertyCallable());

        $assignmentCollection = $mapper->exposeNormalizeCollectionParametersForSelf($parameters);
        foreach ($assignmentCollection as $propertyName => $propertyValue) {
            $mapper->exposeAssignPropertyToSelf($propertyName, $propertyValue);
        }

        static::assertEquals(7, count($mapper->exposeGetObjectVars()));
        static::assertEquals('a-string', $mapper->getPropertyString());
        static::assertNull($mapper->getPropertyInt());
        static::assertNull($mapper->getPropertyArray());
        static::assertNull($mapper->getPropertyCallable());
    }
}

/* EOF */
