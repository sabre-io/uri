<?php declare (strict_types=1);

namespace Sabre\Uri;

function toPunyCode(string $input) : string {

    $output = '';
    $unicodeChars = [];

    $length = mb_strlen($input,'UTF-8');

    for($ii=0; $ii<strlen($input); $ii++) {

        $char = mb_substr($input, $ii, 1, 'UTF-8');
        // Just copy if it's an ascii character
        if (strlen($char)===1 && ord($char) >= 48 && ord($char) <= 127) {
            $output.=$char;
        } else {
            $unicodeChars[] = $char;
        }

    }

    if ($unicodeChars) {

        $output.='-';

    }

    return $output;

}

function fromPunyCode(string $input) : string {

    return $input;

}
