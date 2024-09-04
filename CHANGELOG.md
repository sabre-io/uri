ChangeLog
=========

3.0.2 (2024-09-04)
------------------

* #98: Update readme and test (@phil-davis)
* #100: Update CI and test things (@phil-davis)
* #101: Create dependabot.yml (@DeepDiver1975)
* #102: Bump actions/checkout from 3 to 4 (@DeepDiver1975)
* #103: Change array<int...> to list<...> in PHP doc (@phil-davis)
* #104: Add PHP 8.3 to CI (@phil-davis)
* #105: add convertDeprecationsToExceptions option to unit test settings (@phil-davis)
* and other CI and analysis/test tool changes

3.0.1 (2023-06-09)
------------------

* #89: Call static assert functions with self:: (tests only) (@phil-davis)
* #90: Implement phpstan strict rules and fix edge cases for paths that have "0" (@phil-davis)
* #91: Use newer GitHub workflow action versions (CI only) (@phil-davis)
* #93: Minor cs-fixer change (@phil-davis)

3.0.0 (2022-09-26)
------------------

* #82: Add empty host and leading slash to Windows file paths (@peterpostmann @phil-davis)

2.3.4 (2024-08-27)
------------------

* #111: apply cs-fixer 3.54.0 changes to v2 branch (@phil-davis)
* #115: Add PHP 8.3 to CI for v2 branch (@phil-davis)
* #116: Add PHP 8.4 to CI for v2 branch (@phil-davis)
* #117: check for nullable_type_declaration (@phil-davis)

2.3.3 (2023-06-09)
------------------

* #89: Call static assert functions with self:: (tests only) (@phil-davis)
* #90: Implement phpstan strict rules and fix edge cases for paths that have "0" (@phil-davis)
* #91: Use newer GitHub workflow action versions (CI only) (@phil-davis)
* #93: Minor cs-fixer change (@phil-davis)

2.3.2 (2022-09-19)
------------------

* #83: Revert Windows file paths change (was PR 71). See issue 81 (@phil-davis)

2.3.1 (2022-08-30)
------------------

* #77: Add PHP 8.2 to CI - confirms that the code is working with PHP 8.2 (@phil-davis)
* #78: Raise phpstan to level 8  (@phil-davis)
* #79: Specify detailed return type of parse() (@phil-davis)

2.3.0 (2022-08-17)
------------------

* #74: Minimum PHP 7.4 - drops PHP 7.1 7.2 and 7.3 and adds more type declarations (@phil-davis)

2.2.4 (2022-09-19)
------------------

* #83: Revert Windows file paths change (was PR 71). See issue 81 (@phil-davis)

2.2.3 (2022-08-17)
------------------

* #71: Add empty host and trailing slash to Windows file paths (@peterpostmann @phil-davis)
* #70: Update .gitattributes (@cedric-anne)

2.2.2 (2021-11-04)
------------------

* #69: fix issue with missing slash in URI parse (@41i-6h0rb4n1 @phil-davis)

2.2.1 (2020-10-03)
------------------

* #57: Added Support for PHP 8.0 (@phil-davis)
* #51 #52 #53 #54: Update CI and unit test scripts (@phil-davis)

2.2.0 (2020-01-31)
------------------

* #45: Added Support for PHP 7.4 (@phil-davis, @staabm)
* #47: Dropped Support for PHP 7.0 (@phil-davis)
* #49: Updated the testsuite for phpunit8 (@phil-davis)
* #46: Added phpstan coverage (@phil-davis)

2.1.3 (2019-09-05)
------------------

* #43: allows the path to be 0


2.1.2 (2019-06-25)
------------------

* #39: Some PHPDoc improvements.
* PHPStan support.
* Adopted the symfony php-cs-fixer standard.
* Now testing against PHP 7.2 and 7.3.


2.1.1 (2017-02-20)
------------------

* #15: Don't throw an error when resolving a URI which path component is
  empty.
* #16: Correctly parse urls that are only a fragment `#`.


2.1.0 (2016-12-06)
------------------

* Now throwing `InvalidUriException` if a uri passed to the `parse` function
  is invalid or could not be parsed.
* #11: Fix support for URIs that start with a triple slash. PHP's `parse_uri()`
  doesn't support them, so we now have a pure-php fallback in case it fails.
* #9: Fix support for relative URI's that have a non-uri encoded colon `:` in
  them.


2.0.1 (2016-10-27)
------------------

* #10: Correctly support `file://` URIs in the build() method. (@yuloh)


2.0.0 (2016-10-06)
-----------------

* Requires PHP 7.
* Added type-hints where relevant.


1.2.1 (2017-02-20)
------------------

* #16: Correctly parse urls that are only a fragment `#`.


1.2.0 (2016-12-06)
------------------

* Now throwing `InvalidUriException` if a uri passed to the `parse` function
  is invalid or could not be parsed.
* #11: Fix support for URIs that start with a triple slash. PHP's `parse_uri()`
  doesn't support them, so we now have a pure-php fallback in case it fails.
* #9: Fix support for relative URI's that have a non-uri encoded colon `:` in
  them.


1.1.1 (2016-10-27)
------------------

* #10: Correctly support file:// URIs in the build() method. (@yuloh)


1.1.0 (2016-03-07)
------------------

* #6: PHP's `parse_url()` corrupts strings if they contain certain
  non ascii-characters such as Chinese or Hebrew. sabre/uri's `parse()`
  function now percent-encodes these characters beforehand.


1.0.1 (2015-04-28)
------------------

* #4: Using php-cs-fixer to automatically enforce coding standards.
* #5: Resolving to and building `mailto:` urls were not correctly handled.


1.0.0 (2015-01-27)
------------------

* Added a `normalize` function.
* Added a `buildUri` function.
* Fixed a bug in the `resolve` when only a new fragment is specified.

San José, CalConnect XXXII release!

0.0.1 (2014-11-17)
------------------

* First version!
* Source was lifted from sabre/http package.
* Provides a `resolve` and a `split` function.
* Requires PHP 5.4.8 and up.
