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
 * Class ClassReflectionUnitMockParentTrait.
 */
trait ClassReflectionUnitMockParentTrait
{
    public function publicFunctionParentTrait()
    {
        return 'public::'.__METHOD__;
    }
    protected function protectedFunctionParentTrait()
    {
        return 'protected::'.__METHOD__;
    }
    private function privateFunctionParentTrait()
    {
        return 'private::'.__METHOD__;
    }
}

/* EOF */
