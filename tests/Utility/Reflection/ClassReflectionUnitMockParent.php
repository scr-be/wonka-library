<?php

/*
 * This file is part of the `src-run/wonka-library` project.
 *
 * (c) Rob Frawley 2nd <rmf@src.run>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace SR\Wonka\Tests\Utility\Reflection;

/**
 * Class ClassReflectionUnitMockParent.
 */
class ClassReflectionUnitMockParent extends ClassReflectionUnitMockChild
{
    use ClassReflectionUnitMockParentTrait;

    public $publicPropParent = 'publicPropParent::'.__CLASS__;
    protected $protectedPropParent = 'protectedPropParent::'.__CLASS__;
    private $privatePropParent = 'privatePropParent::'.__CLASS__;

    public function publicFunctionParent()
    {
        return 'public::'.__METHOD__;
    }

    protected function protectedFunctionParent()
    {
        return 'protected::'.__METHOD__;
    }

    private function privateFunctionParent()
    {
        return 'private::'.__METHOD__;
    }
}

/* EOF */
