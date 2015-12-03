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
 * Class ClassReflectionUnitMockChildTrait.
 */
trait ClassReflectionUnitMockChildTrait
{
    public function publicFunctionChildTrait()
    {
        return 'public::'.__METHOD__;
    }
    protected function protectedFunctionChildTrait()
    {
        return 'protected::'.__METHOD__;
    }
    private function privateFunctionChildTrait()
    {
        return 'private::'.__METHOD__;
    }
}

/* EOF */
