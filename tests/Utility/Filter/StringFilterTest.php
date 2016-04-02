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

namespace SR\Wonka\Tests\Utility\Filter;

use SR\Wonka\Utility\UnitTest\WonkaTestCase;
use SR\Wonka\Utility\Filter\StringFilter;

class StringFilterTest extends WonkaTestCase
{
    /**
     * @var StringFilter
     */
    protected $filterString;

    public function setUp()
    {
        parent::setUp();

        $this->filterString = new StringFilter();
    }

    public function testTitleCase()
    {
        $data = [
            ['a cool house and it is not cool', 'A Cool House and It Is Not Cool'],
            ['this should <em>be title cased</em>', 'This Should <em>Be Title Cased</em>'],
            ['a cool house (and it is not cool)', 'A Cool House (And It Is Not Cool)'],
        ];

        foreach ($data as $d) {
            $actual = $this->filterString->titleCase($d[0]);
            static::assertEquals($d[1], $actual);
        }
    }
}

/* EOF */
