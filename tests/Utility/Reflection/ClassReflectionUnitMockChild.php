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

namespace SR\Wonka\Tests\Utility\Reflection;

/**
 * Class ClassReflectionUnitMockChild.
 */
class ClassReflectionUnitMockChild
{
    use ClassReflectionUnitMockChildTrait;

    public $publicPropChild = 'publicPropChild::'.__CLASS__;
    protected $protectedPropChild = 'protectedPropChild::'.__CLASS__;
    private $privatePropChild = 'privatePropChild::'.__CLASS__;

    public function publicFunctionChild()
    {
        return 'public::'.__METHOD__;
    }
    protected function protectedFunctionChild()
    {
        return 'protected::'.__METHOD__;
    }
    private function privateFunctionChild()
    {
        return 'private::'.__METHOD__;
    }
}

/* EOF */
