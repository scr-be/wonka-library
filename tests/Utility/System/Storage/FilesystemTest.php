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

namespace SR\Wonka\Tests\Utility\System\Storage;

use SR\Wonka\Utility\System\Storage\SystemStorage;
use SR\Wonka\Utility\UnitTest\WonkaTestCase;

class FilesystemTest extends WonkaTestCase
{
    public function testGenerateRandom()
    {
        $path = '//www///some/path/to///dir//';
        $expected = '/www/some/path/to/dir/';

        static::assertEquals($expected, (new SystemStorage())->getSanitizedPath($path));
    }

    public function testParseDirectoryPathToParts()
    {
        $systemStorage = new SystemStorage();
        $path = '//www///some/path/to///dir//';

        $resulted = $systemStorage->getPathExploded($path);

        static::assertCount(5, $resulted);

        $expected = [
            '/www',
            '/www/some',
            '/www/some/path',
            '/www/some/path/to',
            '/www/some/path/to/dir',
        ];
        $resulted = $systemStorage->getPathExplodedConcat($path);

        static::assertEquals($expected, $resulted);
        static::assertCount(5, $resulted);

        $expected = 'www/some/path/to/dir';
        $resulted = $systemStorage->getPathImploded($systemStorage->getPathExploded($path));

        static::assertEquals($expected, $resulted);
    }
}

/* EOF */
