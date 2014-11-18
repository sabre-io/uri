<?php

namespace Sabre\Uri;

class FunctionsTest extends \PHPUnit_Framework_TestCase{

    function testSplit() {

        $strings = [

            // input                    // expected result
            '/foo/bar'                 => ['/foo','bar'],
            '/foo/bar/'                => ['/foo','bar'],
            'foo/bar/'                 => ['foo','bar'],
            'foo/bar'                  => ['foo','bar'],
            'foo/bar/baz'              => ['foo/bar','baz'],
            'foo/bar/baz/'             => ['foo/bar','baz'],
            'foo'                      => ['','foo'],
            'foo/'                     => ['','foo'],
            '/foo/'                    => ['','foo'],
            '/foo'                     => ['','foo'],
            ''                         => [null,null],

            // UTF-8
            "/\xC3\xA0fo\xC3\xB3/bar"  => ["/\xC3\xA0fo\xC3\xB3",'bar'],
            "/\xC3\xA0foo/b\xC3\xBCr/" => ["/\xC3\xA0foo","b\xC3\xBCr"],
            "foo/\xC3\xA0\xC3\xBCr"    => ["foo","\xC3\xA0\xC3\xBCr"],

        ];

        foreach($strings as $input => $expected) {

            $output = split($input);
            $this->assertEquals($expected, $output, 'The expected output for \'' . $input . '\' was incorrect');


        }

    }

    /**
     * @dataProvider resolveData
     */
    function testResolve($base, $update, $expected) {

        $this->assertEquals(
            $expected,
            resolve($base, $update)
        );

    }

    function resolveData() {

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
                'http://example.org/foo/bar/',
                '../bar2/.././/bar3/',
                'http://example.org/foo/bar3/',
            ],
        ];

    }

}
