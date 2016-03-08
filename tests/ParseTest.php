<?php

namespace Sabre\Uri;

class ParseTest extends \PHPUnit_Framework_TestCase{

    /**
     * @dataProvider parseData
     */
    function testParse($in, $out) {

        $this->assertEquals(
            $out,
            parse($in)
        );

    }

    function parseData() {

        return [
            [
                'http://example.org/hello?foo=bar#test',
                [
                    'scheme'    => 'http',
                    'host'      => 'example.org',
                    'path'      => '/',
                    'port'      => null,
                    'user'      => null,
                    'query'     => 'foo=bar',
                    'fragement' => 'test'
                ]
            ],
            // See issue #6. parse_url corrupts strings like this, but only on
            // macs.
            /*
            [
                'http://example.org/有词法别名.zh',
                'http://example.org/%E6%9C%89%E8%AF%8D%E6%B3%95%E5%88%AB%E5%90%8D.zh'
            ],*/

        ];

    }

}
