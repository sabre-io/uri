<?php

declare(strict_types=1);

namespace Sabre\Uri;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class NormalizeTest extends TestCase
{
    #[DataProvider('normalizeData')]
    public function testNormalize(string $in, string $out): void
    {
        self::assertEquals(
            $out,
            normalize($in)
        );
    }

    /**
     * @return list<list<string>>
     */
    public static function normalizeData(): array
    {
        return [
            ['https://example.org/',            'https://example.org/'],
            ['http://example.org/',             'http://example.org/'],
            ['HTTP://www.EXAMPLE.com/',         'http://www.example.com/'],
            ['http://example.org/%7Eevert',     'http://example.org/~evert'],
            ['http://example.org/./evert',      'http://example.org/evert'],
            ['http://example.org/../evert',     'http://example.org/evert'],
            ['http://example.org/foo/../evert', 'http://example.org/evert'],
            ['http://example.org/0',            'http://example.org/0'],
            ['/%41',                            '/A'],
            ['/%3F',                            '/%3F'],
            ['/%3f',                            '/%3F'],
            ['http://example.org',              'http://example.org/'],
            ['http://example.org:/',            'http://example.org/'],
            ['http://example.org:80/',          'http://example.org/'],
            // rfc3986, sections 5.2.4 and 6.2.2.3: a trailing "." or ".."
            // segment leaves the "/" behind.
            ['http://example.org/a/b/.',        'http://example.org/a/b/'],
            ['http://example.org/a/b/..',       'http://example.org/a/'],
            ['http://example.org/a/./b/',       'http://example.org/a/b/'],
            ['http://example.org/a/b/../',      'http://example.org/a/'],
            ['http://example.org/..',           'http://example.org/'],
            ['http://example.org/a/../../b',    'http://example.org/b'],
            // %2E decodes to "." (section 2.3), which makes it a dot segment.
            ['http://example.org/a/%2E/b',      'http://example.org/a/b'],
            ['http://example.org/a/%2e%2E/b',   'http://example.org/b'],
            // An empty segment is a segment; "//" is not the same path as "/".
            ['http://example.org//a',           'http://example.org//a'],
            ['http://example.org/a//b',         'http://example.org/a//b'],
            // A rootless path stays rootless.
            ['mailto:evert@example.org',        'mailto:evert@example.org'],
            // rfc3986, section 3.3: all of these are valid pchar and must be
            // left as they are. Encoding them would change what the URI means
            // (section 2.2).
            ['http://example.org/a!b',          'http://example.org/a!b'],
            ['http://example.org/a$b',          'http://example.org/a$b'],
            ['http://example.org/a&b',          'http://example.org/a&b'],
            ["http://example.org/a'b",          "http://example.org/a'b"],
            ['http://example.org/a(b',          'http://example.org/a(b'],
            ['http://example.org/a)b',          'http://example.org/a)b'],
            ['http://example.org/a*b',          'http://example.org/a*b'],
            ['http://example.org/a+b',          'http://example.org/a+b'],
            ['http://example.org/a,b',          'http://example.org/a,b'],
            ['http://example.org/a;b',          'http://example.org/a;b'],
            ['http://example.org/a=b',          'http://example.org/a=b'],
            ['http://example.org/a:b',          'http://example.org/a:b'],
            ['http://example.org/a@b',          'http://example.org/a@b'],
            ['http://a/b/c/d;p?q',              'http://a/b/c/d;p?q'],
            // ... while their triplets stay encoded, so that the two forms do
            // not compare equal.
            ['http://example.org/a%3Bb',        'http://example.org/a%3Bb'],
            ['http://example.org/a%2fb',        'http://example.org/a%2Fb'],
            // Anything that is not a pchar still gets encoded.
            ['http://example.org/a b',          'http://example.org/a%20b'],
            ['http://example.org/a[b]',         'http://example.org/a%5Bb%5D'],
            ['http://example.org/a%b',          'http://example.org/a%25b'],
            // See issue #6. parse_url corrupts strings like this, but only on
            // macs.
            // [ 'http://example.org/有词法别名.zh','http://example.org/%E6%9C%89%E8%AF%8D%E6%B3%95%E5%88%AB%E5%90%8D.zh'],
        ];
    }
}
