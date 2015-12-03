<?php

/*
 * This file is part of the scribe/wonka-bundle.
 *
 * (c) Scribe Inc. <rmf@scr.be>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\Wonka\Tests\Utility\Reflection;

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
