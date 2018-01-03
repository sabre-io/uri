<?php declare (strict_types=1);

namespace Sabre\Uri;

class ReplaceTest extends \PHPUnit\Framework\TestCase {

    /**
     * @dataProvider resolveData
     */
    function testReplace($base, $update, $expected) {

        $this->assertEquals(
            $expected,
            replace($base, $update)
        );

    }

    function resolveData() {

        return [
            [
                'http://example.org/foo/baz',
                ['scheme' => 'https'],
                'https://example.org/foo/baz',
            ],
            [
                'http://example.org/foo/baz',
                ['host' => 'test.org'],
                'http://test.org/foo/baz',
            ],
            [
                'https://example.org/foo?a=b',
                ['path' => '/hello'],
                'https://example.org/hello?a=b',
            ],[
                'https://example.org/foo?a=b',
                ['query' => 'c=d'],
                'https://example.org/foo?c=d',
            ],
            // Ports and fragments
            [
                'https://example.org:81/foo#hey',
                ['port' => '9000'],
                'https://example.org:9000/foo#hey',
            ],
            [
                'https://example.org/foo?a=b#comments',
                ['fragment' => 'posts'],
                'https://example.org/foo?a=b#posts',
            ],
            [
                'http://user@example.org:81',
                ['user' => 'test'],
                'http://test@example.org:81',
            ],
        ];

    }

}
