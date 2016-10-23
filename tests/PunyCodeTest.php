<?php declare (strict_types=1);

namespace Sabre\Uri;

class PunyCodeTest extends \PHPUnit_Framework_TestCase {

    /**
     * @dataProvider punyCodeData
     */
    function testToPunyCode($input, $output) {

        $this->assertEquals($output, toPunyCode($input));

    }

    function punyCodeData() {

        return [
            ["café.example.org", "xn--caf-dma.com"],
        ];

    }

}
