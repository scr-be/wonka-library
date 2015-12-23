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

namespace Scribe\Wonka\Tests\Exception;

use Scribe\Wonka\Exception\ExceptionTrait;
use Scribe\Wonka\Utility\UnitTest\WonkaTestCase;

/**
 * Class ExceptionTraitTest.
 */
class ExceptionTraitTest extends WonkaTestCase
{
    /**
     * @var ExceptionTrait
     */
    protected static $e;

    public function setUp()
    {
        static::$e = $this->getMockBuilder('Scribe\Wonka\Exception\ExceptionTrait')
            ->disableOriginalConstructor()
            ->getMockForTrait();

        parent::setUp();
    }

    public function testToString()
    {
        static::assertStringStartsWith('Array', static::$e->__toString());
    }

    public function testDebugOutput()
    {
        static::assertArraySubset(['trace' => []], static::$e->getDebugOutput());
    }

    public function testType()
    {
        static::assertRegExp('{^Mock_Trait_ExceptionTrait_.+}', static::$e->getType());
    }

    public function testGetMessageSprintf()
    {
        static::assertEquals('A test string with number "10".', static::$e->getFinalMessage('A %s string with number "%d".', 'test', 10));
    }

    public function testSetAttributes()
    {
        $a = [
            'index-string' => 'value 01',
            'numeric index',
        ];

        static::$e->setAttributes($a);
        static::assertEquals($a, static::$e->getAttributes());
    }

    public function testAddAttribute()
    {
        $a = ['index-string' => 'value 01'];
        $b = ['numeric-index-value'];

        static::$e->addAttribute(current($a), key($a));
        static::assertEquals($a, static::$e->getAttributes());
        static::$e->addAttribute(current($b));
        static::assertEquals(array_merge($a, $b), static::$e->getAttributes());
    }
}

/* EOF */
