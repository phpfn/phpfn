<p align="center">
    <h1>Functional PHP</h1>
</p>
<p align="center">
    <a href="https://travis-ci.org/github/phpfn/phpfn"><img src="https://travis-ci.org/phpfn/phpfn.svg?branch=master" alt="Travis CI" /></a>
    <a href="https://codeclimate.com/github/phpfn/phpfn/test_coverage"><img src="https://api.codeclimate.com/v1/badges/47017eee0be4b7544b1b/test_coverage" /></a>
    <a href="https://codeclimate.com/github/phpfn/phpfn/maintainability"><img src="https://api.codeclimate.com/v1/badges/47017eee0be4b7544b1b/maintainability" /></a>
</p>
<p align="center">
    <a href="https://packagist.org/packages/phpfn/"><img src="https://img.shields.io/badge/PHP-7.4+-236d98.svg" alt="PHP 7.4+"></a>
    <a href="https://packagist.org/packages/phpfn/"><img src="https://img.shields.io/badge/PHP-8.0%20Compatible-236d98.svg" alt="PHP 8.0 Compatible"></a>
    <a href="https://raw.githubusercontent.com/phpfn/phpfn/master/LICENSE.md"><img src="https://poser.pugx.org/phpfn/phpfn/license" alt="License MIT"></a>
</p>

## Installation

Library can be installed into any PHP application:
- Using [`Composer`](https://getcomposer.org/) dependency manager 
- [The Force](https://www.youtube.com/watch?v=o2we_B6hDrY) for the Jedi Developers

```sh
$ composer require phpfn/phpfn
```

In order to access library make sure to include `vendor/autoload.php` 
in your file.

```php
<?php

require __DIR__ . '/vendor/autoload.php';
```

## Usage

This package includes

- [`phpfn/symbol`](https://github.com/phpfn/symbol) for the ability to create unique identifiers within the system.
- [`phpfn/placeholder`](https://github.com/phpfn/placeholder) placeholder (looks like that: `_`) symbol implementation.
- [`phpfn/pipe`](https://github.com/phpfn/pipe) the ability to use a sequence of functions as a chain.
- [`phpfn/curry`](https://github.com/phpfn/curry) implementation of currying and partial application.
