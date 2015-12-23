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

namespace Scribe\Wonka\Tests\Utility;

use Scribe\Wonka\Utility\ClassInfo;
use Scribe\Wonka\Utility\UnitTest\WonkaTestCase;

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
            'Scribe\Wonka\Exception\BadFunctionCallException',
            'The requested static function getinvalidMethodCall does not exist for class Scribe\Wonka\Utility\ClassInfo (or is not callable).'
        );

        static::assertEquals(
            'ClassInfoTest',
            ClassInfo::get(__CLASS__, 'invalidMethodCall')
        );
    }

    public function testGetNamespace()
    {
        static::assertEquals(
            'Scribe\Wonka\Tests\Utility\\',
            ClassInfo::getNamespace(__CLASS__)
        );

        static::assertEquals(
            [
                'Scribe',
                'Wonka',
                'Tests',
                'Utility',
            ],
            ClassInfo::getNamespaceSet(__CLASS__)
        );

        static::assertEquals(
            'Scribe\Wonka\Tests\Utility\\',
            ClassInfo::getNamespaceByInstance($this)
        );

        static::assertEquals(
            [
                'Scribe',
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
        $trait = 'Scribe\SomeRandomTrait';

        static::assertEquals(
            'SomeRandomTrait',
            ClassInfo::getTraitName($trait)
        );
    }
}

/* EOF */
