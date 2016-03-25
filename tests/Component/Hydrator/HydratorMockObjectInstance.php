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

namespace SR\Wonka\Tests\Component\Hydrator;

/**
 * Class HydratorMockObjectInstance.
 */
class HydratorMockObjectInstance
{
    public $publicProp;
    public $random_public_prop;
    protected $protectedProp;
    protected $random_protected_prop;
    private $privateProp;
    private $random_private_prop;

    public function setPublicProp($value)
    {
        $this->publicProp = $value;

        return $this;
    }

    public function setProtectedProp($value)
    {
        $this->protectedProp = $value;

        return $this;
    }

    public function setPrivateProp($value)
    {
        $this->privateProp = $value;

        return $this;
    }

    public function setRandomPublicProp($value)
    {
        $this->random_public_prop = $value;

        return $this;
    }

    public function setRandomProtectedProp($value)
    {
        $this->random_protected_prop = $value;

        return $this;
    }

    public function setRandomPrivateProp($value)
    {
        $this->random_private_prop = $value;

        return $this;
    }
}

/* EOF */
