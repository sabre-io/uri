<?php

declare(strict_types=1);

namespace Sabre\Uri;

use PHPUnit\Framework\TestCase;

class NormalizeTest extends TestCase
{
    /**
     * @dataProvider normalizeData
     */
    public function testNormalize(string $in, string $out): void
    {
        self::assertEquals(
            $out,
            normalize($in)
        );
    }

    /**
     * @return array<int, array<int, string>>
     */
    public function normalizeData(): array
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
            // See issue #6. parse_url corrupts strings like this, but only on
            // macs.
            // [ 'http://example.org/有词法别名.zh','http://example.org/%E6%9C%89%E8%AF%8D%E6%B3%95%E5%88%AB%E5%90%8D.zh'],
        ];
    }
}
