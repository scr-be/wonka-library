<?php

/*
 * This file is part of the `src-run/wonka-library` project.
 *
 * (c) Rob Frawley 2nd <rmf@src.run>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace SR\Wonka\Utility\Reflection;

/**
 * Class ClassReflectionAnalyser.
 */
class ClassReflectionAnalyser implements ClassReflectionAnalyserInterface
{
    /*
     * Include base functionality via trait.
     */
    use ClassReflectionAnalyserTrait;

    /**
     * @param string|null $class
     *
     * @return $this
     */
    public static function create($class = null)
    {
        return new self($class === null ? null : new \ReflectionClass($class));
    }

    /**
     * Optional injection at instantiation of reflection class for analysis.
     *
     * @param \ReflectionClass $reflectionClass
     */
    public function __construct(\ReflectionClass $reflectionClass = null)
    {
        if ($reflectionClass instanceof \ReflectionClass) {
            $this->setReflectionClass($reflectionClass);
        }
    }
}

/* EOF */
