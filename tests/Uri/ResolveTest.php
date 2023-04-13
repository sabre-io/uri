<?php

declare(strict_types=1);

namespace Sabre\Uri;

use PHPUnit\Framework\TestCase;

class ResolveTest extends TestCase
{
    /**
     * @dataProvider resolveData
     *
     * @throws InvalidUriException
     */
    public function testResolve(string $base, string $update, string $expected): void
    {
        self::assertEquals(
            $expected,
            resolve($base, $update)
        );
    }

    /**
     * @return array<int, array<int, string>>
     */
    public function resolveData(): array
    {
        return [
            [
                'http://example.org/foo/baz',
                '/bar',
                'http://example.org/bar',
            ],
            [
                'https://example.org/foo',
                '//example.net/',
                'https://example.net/',
            ],
            [
                'https://example.org/foo',
                '?a=b',
                'https://example.org/foo?a=b',
            ],
            [
                '//example.org/foo',
                '?a=b',
                '//example.org/foo?a=b',
            ],
            // Ports and fragments
            [
                'https://example.org:81/foo#hey',
                '?a=b#c=d',
                'https://example.org:81/foo?a=b#c=d',
            ],
            // Relative.. in-directory paths
            [
                'http://example.org/foo/bar',
                'bar2',
                'http://example.org/foo/bar2',
            ],
            // Now the base path ended with a slash
            [
                'http://example.org/foo/bar/',
                'bar2/bar3',
                'http://example.org/foo/bar/bar2/bar3',
            ],
            // .. and .
            [
                'http://example.org',
                './bar2/../../bar3/',
                'http://example.org/bar3/',
            ],
            // .. and .
            [
                'http://example.org/foo/bar/',
                '../bar2/.././/bar3/',
                'http://example.org/foo//bar3/',
            ],
            // Only updating the fragment
            [
                'https://example.org/foo?a=b',
                '#comments',
                'https://example.org/foo?a=b#comments',
            ],
            [
                'https://example.org/foo?0',
                '#comments',
                'https://example.org/foo?0#comments',
            ],
            // Switching to mailto!
            [
                'https://example.org/foo?a=b',
                'mailto:foo@example.org',
                'mailto:foo@example.org',
            ],
            // Resolving empty path
            [
                'http://www.example.org',
                '#foo',
                'http://www.example.org/#foo',
            ],
            // Another fragment test
            [
                'http://example.org/path.json',
                '#',
                'http://example.org/path.json',
            ],
            [
                'http://www.example.com',
                '#',
                'http://www.example.com/',
            ],
            [
                'http://www.example.org',
                '#foo',
                'http://www.example.org/#foo',
            ],
            // Allow to use 0 in path
            [
                'http://example.org/',
                '0',
                'http://example.org/0',
            ],
            // Allow to use 0 in base path
            [
                'http://example.org/0',
                '//example.net',
                'http://example.net/0',
            ],
            [
                'http://example.org/0',
                '//example.net/',
                'http://example.net/',
            ],
            // Allow to use a base with only the path
            [
                '0',
                '//example.net',
                '//example.net/0',
            ],
            [
                'a',
                '//example.net',
                '//example.net/a',
            ],
            [
                '0',
                '//example.net/',
                '//example.net/',
            ],
            [
                'a',
                '//example.net/',
                '//example.net/',
            ],
            // Allow to use an empty base
            [
                '',
                '//example.net',
                '//example.net/',
            ],
            [
                '',
                '//example.net/',
                '//example.net/',
            ],
            // Windows Paths
            [
                'file:///C:/path/file_a.ext',
                'file_b.ext',
                'file:///C:/path/file_b.ext',
            ],
            [
                'file:///C:/path/of/dirs/',
                'file.txt',
                'file:///C:/path/of/dirs/file.txt',
            ],
        ];
    }
}
