sabre/uri
=========

Functions that help with uris.


Installation
------------

Make sure you have [composer][3] installed, and then run:

    composer require sabre/uri


Usage
-----

This package provides 2 functions:

1. `resolve`
2. `splitPath`

### resolve

Resolves a relative url based on another url.

    Sabre\Uri::resolve(
        'http://example.org/foo/bar/',
        '/'
    );
    // Result: http://example.org/

    Sabre\Uri::resolve(
        '/foo/',
        '?a=b'
    );
    // Result: /foo/?a=b


### split

This is a combination of PHP's [`dirname`][6] and [`basename`][7],
without being affected by locale settings.

    list(
        $parent,
        $baseName
    ) = split('http://example.org/foo/bar');

    echo $parent, " ", $baseName;
    // output : http://example.org/foo bar

* Unlike dirname/basename, this method only treats `/` as a directory
  separator.
* Unlike dirname/basename, the behavior of this method does not change
  depending on the system's locale setting.
* Slashes appearing at the end of the path input path will be ignored.
* If there's no 'dirname' part, an empty string will be returned, unlike
  dirname, which would return a `.`.


Build status
------------

| branch | status |
| ------ | ------ |
| master | [![Build Status](https://travis-ci.org/fruux/sabre-uri.png?branch=master)](https://travis-ci.org/fruux/sabre-uri) |


Questions?
----------

Head over to the [sabre/dav mailinglist][4], or you can also just open a ticket
on [GitHub][5].


Made at fruux
-------------

This library is being developed by [fruux](https://fruux.com/). Drop us a line for commercial services or enterprise support.

[1]: http://sabre.io/uri/
[3]: http://getcomposer.org/
[4]: http://groups.google.com/group/sabredav-discuss
[5]: https://github.com/fruux/sabre-uri/issues/
[6]: http://php.net/manual/en/function.dirname.php
[7]: http://php.net/manual/en/function.basename.php
