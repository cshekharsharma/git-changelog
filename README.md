Git Change Log
--------------

A simple PHP library for generating changelog file by parsing git log history.

[![Latest Stable Version](https://img.shields.io/packagist/v/cshekharsharma/git-changelog.svg)](https://packagist.org/packages/cshekharsharma/git-changelog)
[![Minimum PHP Version](https://img.shields.io/badge/php-%3E%3D%205.5-8892BF.svg)](https://php.net/)
[![Build Status](https://img.shields.io/travis/cshekharsharma/git-changelog/master.svg)](https://travis-ci.org/cshekharsharma/git-changelog)
[![License](https://poser.pugx.org/laravel/framework/license.svg)](https://packagist.org/packages/cshekharsharma/git-changelog)


git-changelog parses the git history at provided `working directory` within the duration of `start date` and `end date`, and generates change logs.

Changelogs can be generated in following output formats, by setting `output format` property while generating logs.
- Markdown (Standard MD format)
- Remarkup (See Phabricator remarkup guide)
- HTML
- JSON

## Commit format

git-changelog expects commits to be in following format-

`type : commit-message`

Type can be one of the following values-
- fix
- feature
- general
- security

if commit message does not follow this format, or the provided `type` is other than the provided 4 types, then the commit message is categories under `general` type.


## Installation

Install the latest version with

```bash
$ composer require cshekharsharma/git-changelog
```

## Basic Usage

```php
<?php

use GitChangeLog\Constants;

require_once '../vendor/autoload.php';

$generator = new \GitChangeLog\ChangeLogGenerator();

$generator->setStartDate('2018-01-01');
$generator->setEndDate('2018-04-01');
$generator->setWorkingDir('/path/to/git/repository');

$generator->setOutputFormat(Constants::OUTPUT_FORMAT_MARKDOWN);

$changelogs = $generator->generate();

```


## Third Party Packages

No third party packages is used in git-changelog.

## About

### Requirements

- git-changelog works with PHP 5.5 or above.


### Author

Chandra Shekhar Sharma <shekharsharma705@gmail.com>

### License

git-changelog is licensed under the MIT License - see the `LICENSE` file for details
