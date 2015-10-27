<?php

/*
 * This file is part of the scribe/wonka-bundle.
 *
 * (c) Scribe Inc. <rmf@scr.be>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\Wonka\Tests\Utility\System\Storage;

use Scribe\Wonka\Utility\System\Storage\SystemStorage;
use Scribe\Wonka\Utility\UnitTest\WonkaTestCase;

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
