<?php

declare(strict_types=1);

namespace Sabre\Uri;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class ResolveTest extends TestCase
{
    /**
     * @throws InvalidUriException
     */
    #[DataProvider('resolveData')]
    public function testResolve(string $base, string $update, string $expected): void
    {
        self::assertEquals(
            $expected,
            resolve($base, $update)
        );
    }

    /**
     * @throws InvalidUriException
     */
    #[DataProvider('rfc3986ResolveData')]
    public function testResolveRfc3986Examples(string $reference, string $expected): void
    {
        self::assertEquals(
            $expected,
            resolve('http://a/b/c/d;p?q', $reference)
        );
    }

    /**
     * The reference resolution examples from rfc3986, sections 5.4.1 and 5.4.2,
     * all against the base URI the RFC uses there.
     *
     * The empty reference is left out on purpose: it is the subject of open
     * pull request #145.
     *
     * @return list<list<string>>
     */
    public static function rfc3986ResolveData(): array
    {
        return [
            // 5.4.1 Normal Examples
            ['g:h', 'g:h'],
            ['g', 'http://a/b/c/g'],
            ['./g', 'http://a/b/c/g'],
            ['g/', 'http://a/b/c/g/'],
            ['/g', 'http://a/g'],
            ['//g', 'http://g'],
            ['?y', 'http://a/b/c/d;p?y'],
            ['g?y', 'http://a/b/c/g?y'],
            ['#s', 'http://a/b/c/d;p?q#s'],
            ['g#s', 'http://a/b/c/g#s'],
            ['g?y#s', 'http://a/b/c/g?y#s'],
            [';x', 'http://a/b/c/;x'],
            ['g;x', 'http://a/b/c/g;x'],
            ['g;x?y#s', 'http://a/b/c/g;x?y#s'],
            ['.', 'http://a/b/c/'],
            ['./', 'http://a/b/c/'],
            ['..', 'http://a/b/'],
            ['../', 'http://a/b/'],
            ['../g', 'http://a/b/g'],
            ['../..', 'http://a/'],
            ['../../', 'http://a/'],
            ['../../g', 'http://a/g'],
            // 5.4.2 Abnormal Examples
            ['../../../g', 'http://a/g'],
            ['../../../../g', 'http://a/g'],
            ['/./g', 'http://a/g'],
            ['/../g', 'http://a/g'],
            ['g.', 'http://a/b/c/g.'],
            ['.g', 'http://a/b/c/.g'],
            ['g..', 'http://a/b/c/g..'],
            ['..g', 'http://a/b/c/..g'],
            ['./../g', 'http://a/b/g'],
            ['./g/.', 'http://a/b/c/g/'],
            ['g/./h', 'http://a/b/c/g/h'],
            ['g/../h', 'http://a/b/c/h'],
            ['g;x=1/./y', 'http://a/b/c/g;x=1/y'],
            ['g;x=1/../y', 'http://a/b/c/y'],
            ['g?y/./x', 'http://a/b/c/g?y/./x'],
            ['g?y/../x', 'http://a/b/c/g?y/../x'],
            ['g#s/./x', 'http://a/b/c/g#s/./x'],
            ['g#s/../x', 'http://a/b/c/g#s/../x'],
            // The RFC gives two answers here, one for strict parsers and one
            // for backwards compatibility. This is the strict one.
            ['http:g', 'http:g'],
        ];
    }

    /**
     * @return list<list<string>>
     */
    public static function resolveData(): array
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
                '#foo',
                'http://example.org/0#foo',
            ],
            [
                'http://example.org/0',
                '//example.net',
                'http://example.net',
            ],
            [
                'http://example.org/0',
                '//example.net/',
                'http://example.net/',
            ],
            // Allow to use a base with only the path
            [
                '0',
                '#foo',
                '/0#foo',
            ],
            [
                '0',
                '//example.net',
                '//example.net',
            ],
            [
                'a',
                '//example.net',
                '//example.net',
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
                '//example.net',
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
