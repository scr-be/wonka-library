<?php

/*
 * This file is part of the `src-run/wonka-library` project.
 *
 * (c) Rob Frawley 2nd <rmf@src.run>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace SR\Wonka\Utility\StaticClass;

use SR\Exception\Runtime\RuntimeException;

/**
 * StaticClassTrait
 * Disallows class instantiation by throwing an exception within the constructor.
 */
trait StaticClassTrait
{
    /**
     * Disallow class instantiation by issuing an exception for classes with only static methods.
     *
     * @param mixed ...$values Any values that may be passed are ignored.
     */
    final public function __construct(...$values)
    {
        throw new RuntimeException('Cannot instantiate static class %s.', get_called_class());
    }
}

/* EOF */
