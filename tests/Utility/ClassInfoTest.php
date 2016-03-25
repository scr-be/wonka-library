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

namespace SR\Wonka\Tests\Utility;

use SR\Wonka\Utility\ClassInfo;
use SR\Wonka\Utility\UnitTest\WonkaTestCase;

class ClassInfoTest extends WonkaTestCase
{
    public function testGet()
    {
        static::assertEquals(
            'ClassInfoTest',
            ClassInfo::get(__CLASS__, ClassInfo::CLASS_STR)
        );

        static::assertEquals(
            'ClassInfoTest',
            ClassInfo::getByInstance($this, ClassInfo::CLASS_STR)
        );

        $this->setExpectedException(
            'SR\Wonka\Exception\BadFunctionCallException',
            'The requested static function getinvalidMethodCall does not exist for class SR\Wonka\Utility\ClassInfo (or is not callable).'
        );

        static::assertEquals(
            'ClassInfoTest',
            ClassInfo::get(__CLASS__, 'invalidMethodCall')
        );
    }

    public function testGetNamespace()
    {
        static::assertEquals(
            'SR\Wonka\Tests\Utility\\',
            ClassInfo::getNamespace(__CLASS__)
        );

        static::assertEquals(
            [
                'SR',
                'Wonka',
                'Tests',
                'Utility',
            ],
            ClassInfo::getNamespaceSet(__CLASS__)
        );

        static::assertEquals(
            'SR\Wonka\Tests\Utility\\',
            ClassInfo::getNamespaceByInstance($this)
        );

        static::assertEquals(
            [
                'SR',
                'Wonka',
                'Tests',
                'Utility',
            ],
            ClassInfo::getNamespaceSetByInstance($this)
        );

        static::assertEquals(
            4,
            ClassInfo::getNamespaceLevels(__CLASS__)
        );

        static::assertEquals(
            4,
            ClassInfo::getNamespaceLevelsByInstance($this)
        );
    }

    public function testGetClassName()
    {
        static::assertEquals(
            'ClassInfoTest',
            ClassInfo::getClassName(__CLASS__)
        );

        static::assertEquals(
            'ClassInfoTest',
            ClassInfo::getClassNameByInstance($this)
        );
    }

    public function testGetTraitName()
    {
        $trait = 'SR\SomeRandomTrait';

        static::assertEquals(
            'SomeRandomTrait',
            ClassInfo::getTraitName($trait)
        );
    }
}

/* EOF */
