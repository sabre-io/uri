<?php

namespace Sabre\Uri;

/**
 * Returns the 'dirname' and 'basename' for a path.
 *
 * The reason there is a custom function for this purpose, is because
 * basename() is locale aware (behaviour changes if C locale or a UTF-8 locale
 * is used) and we need a method that just operates on UTF-8 characters.
 *
 * In addition basename and dirname are platform aware, and will treat
 * backslash (\) as a directory separator on windows.
 *
 * This method returns the 2 components as an array.
 *
 * If there is no dirname, it will return an empty string. Any / appearing at
 * the end of the string is stripped off.
 *
 * @param string $path
 * @return array
 */
function split($path) {

    $matches = [];
    if(preg_match('/^(?:(?:(.*)(?:\/+))?([^\/]+))(?:\/?)$/u',$path,$matches)) {
        return [$matches[1], $matches[2]];
    } else {
        return [null,null];
    }

}

/**
 * Resolves relative urls, like a browser would.
 *
 * This function takes a basePath, which itself _may_ also be relative, and
 * then applies the relative path on top of it.
 *
 * @param string $basePath
 * @param string $newPath
 * @return string
 */
function resolve($basePath, $newPath) {

    $base = parse_url($basePath);
    $delta = parse_url($newPath);

    $pick = function($part) use ($base, $delta) {

        if (isset($delta[$part])) {
            return $delta[$part];
        } elseif (isset($base[$part])) {
            return $base[$part];
        } else {
            return null;
        }

    };

    $url = '';
    $scheme = $pick('scheme');
    $host = $pick('host');

    if ($scheme) {
        // If there's a scheme, there's also a host.
        $url=$scheme.'://' . $host;
    } elseif ($host) {
        // No scheme, but there is a host.
        $url = '//' . $host;
    }

    $port = $pick('port');
    if ($port) {
        // tcp port.
        $url.=':' . $port;
    }

    $path = '';
    if (isset($delta['path'])) {
        // If the path starts with a slash
        if ($delta['path'][0]==='/') {
            $path = $delta['path'];
        } else {
            // Removing last component from base path.
            $path = $base['path'];
            if (strpos($path, '/')!==false) {
                $path = substr($path,0,strrpos($path,'/'));
            }
            $path.='/' . $delta['path'];
        }
    } else {
        $path = isset($base['path'])?$base['path']:'/';
    }
    // Removing .. and .
    $pathParts = explode('/', $path);
    $newPathParts = [];
    foreach($pathParts as $pathPart) {

        switch($pathPart) {
            case '' :
            case '.' :
                break;
            case '..' :
                array_pop($newPathParts);
                break;
            default :
                $newPathParts[] = $pathPart;
                break;
        }
    }

    $url.='/' . implode('/', $newPathParts);

    // If the source url ended with a /, we want to preserve that.
    if (substr($path, -1) === '/' && $path!=='/') {
        $url.='/';
    }

    if (isset($delta['query'])) {
        $url.='?' . $delta['query'];
    }
    if (isset($delta['fragment'])) {
        $url.='#' . $delta['fragment'];
    }

    return $url;

}

/**
 * Takes a URI or partial URI as its argument, and normalizes it.
 *
 * After normalizing a URI, you can safely compare it to other URIs.
 * This function will for instance convert a %7E into a tilde, according to
 * rfc3986.
 *
 * It will also change a %3a into a %3A.
 *
 * @param string $uri
 * @return string
 */
function normalize($uri) {

    $parts = parse_url($uri);

    if (!empty($parts['path'])) {
        $pathParts = explode('/', ltrim($parts['path'], '/'));
        $newPathParts = [];
        foreach($pathParts as $pathPart) {
            switch($pathPart) {
                case '.':
                    // skip
                    break;
                case '..' :
                    // One level up in the hierarchy
                    array_pop($newPathParts);
                    break;
                default :
                    // Ensuring that everything is correctly percent-encoded.
                    $newPathParts[] = rawurlencode(rawurldecode($pathPart));
                    break;
            }
        }
        $parts['path'] = '/' . implode('/', $newPathParts);
    }

    if (isset($parts['scheme'])) {
        $parts['scheme'] = strtolower($parts['scheme']);
        $defaultPorts = [
            'http'  => '80',
            'https' => '443',
        ];

        if (!empty($parts['port']) && isset($defaultPorts[$parts['scheme']]) && $defaultPorts[$parts['scheme']]==$parts['port']) {
            // Removing default ports.
            unset($parts['port']);
        }
        // A few HTTP specific rules.
        switch($parts['scheme']) {
            case 'http' :
            case 'https' :
                if (empty($parts['path'])) {
                    // An empty path is equivalent to / in http.
                    $parts['path'] = '/';
                }
                break;
        }
    }

    if (isset($parts['host'])) $parts['host'] = strtolower($parts['host']);

    return buildUri($parts);

}


/**
 * This function takes the components returned from PHP's parse_url, and uses
 * it to generate a new uri.
 */
function buildUri($parts) {

    $uri = '';

    $authority = '';
    if (!empty($parts['host'])) {
        $authority = $parts['host'];
        if (!empty($parts['user'])) {
            $authority = $parts['user'] . '@' . $authority;
        }
        if (!empty($parts['port'])) {
            $authority = $authority . ':' . $parts['port'];
        }
    }

    if (!empty($parts['scheme'])) {
        // If there's a scheme, there's also a host.
        $uri=$parts['scheme'].'://' . $authority;

    } elseif ($authority) {
        // No scheme, but there is a host.
        $uri = '//' . $authority;

    }

    if (!empty($parts['path'])) {
        $uri.=$parts['path'];
    }
    if (!empty($parts['query'])) {
        $uri.='?' . $parts['query'];
    }
    if (!empty($parts['fragment'])) {
        $uri.='#' . $parts['fragment'];
    }

    return $uri;

}
