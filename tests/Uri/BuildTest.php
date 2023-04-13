<?php

declare(strict_types=1);

namespace Sabre\Uri;

use PHPUnit\Framework\TestCase;

class BuildTest extends TestCase
{
    /**
     * @dataProvider buildUriData
     */
    public function testBuild(string $value): void
    {
        /** @var array<string, int|string> $parsedUrl */
        $parsedUrl = parse_url($value);
        self::assertIsArray($parsedUrl);
        self::assertEquals(
            $value,
            build($parsedUrl)
        );
    }

    /**
     * @return array<int, array<int, string>>
     */
    public function buildUriData(): array
    {
        return [
            ['http://example.org/'],
            ['http://example.org/foo/bar'],
            ['//example.org/foo/bar'],
            ['/foo/bar'],
            ['0'],
            ['http://example.org:81/'],
            ['http://user@example.org:81/'],
            ['http://0@example.org:81/'],
            ['http://example.org:81/hi?a=b'],
            ['http://example.org:81/hi?a=b#c=d'],
            // [ '//example.org:81/hi?a=b#c=d'], // Currently fails due to a
            // PHP bug.
            ['/hi?a=b#c=d'],
            ['?a=b#c=d'],
            ['?0'],
            ['#c=d'],
            ['#0'],
            ['file:///etc/hosts'],
            ['file://localhost/etc/hosts'],
        ];
    }
}
