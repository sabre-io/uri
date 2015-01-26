<?php

namespace Sabre\Uri;

class BuildUriTest extends \PHPUnit_Framework_TestCase{

    /**
     * @dataProvider buildUriData
     */
    function testBuildUri($value) {

        $this->assertEquals(
            $value,
            buildUri(parse_url($value))
        );

    }

    function buildUriData() {

        return [
            [ 'http://example.org/'],
            [ 'http://example.org/foo/bar'],
            [ '//example.org/foo/bar'],
            [ '/foo/bar'],
            [ 'http://example.org:81/'],
            [ 'http://example.org:81/hi?a=b'],
            [ 'http://example.org:81/hi?a=b#c=d'],
            // [ '//example.org:81/hi?a=b#c=d'], // Currently fails due to a
            // PHP bug.
            [ '/hi?a=b#c=d'],
            [ '?a=b#c=d'],
            [ '#c=d'],
        ];

    }

}
