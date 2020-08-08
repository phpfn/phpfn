<p align="center">
    <h1>Placeholder</h1>
</p>
<p align="center">
    <a href="https://travis-ci.org/SerafimArts/Placeholder"><img src="https://travis-ci.org/SerafimArts/Placeholder.svg" alt="Travis CI" /></a>
    <a href="https://codeclimate.com/github/SerafimArts/Placeholder/test_coverage"><img src="https://api.codeclimate.com/v1/badges/122f1fac63b6b5a26117/test_coverage" /></a>
    <a href="https://codeclimate.com/github/SerafimArts/Placeholder/maintainability"><img src="https://api.codeclimate.com/v1/badges/122f1fac63b6b5a26117/maintainability" /></a>
</p>
<p align="center">
    <a href="https://packagist.org/packages/serafim/placeholder"><img src="https://img.shields.io/badge/PHP-7.1+-6f4ca5.svg" alt="PHP 7.1+"></a>
    <a href="https://packagist.org/packages/serafim/placeholder"><img src="https://poser.pugx.org/serafim/placeholder/version" alt="Latest Stable Version"></a>
    <a href="https://packagist.org/packages/serafim/placeholder"><img src="https://poser.pugx.org/serafim/placeholder/downloads" alt="Total Downloads"></a>
    <a href="https://raw.githubusercontent.com/SerafimArts/Placeholder/master/LICENSE.md"><img src="https://poser.pugx.org/serafim/placeholder/license" alt="License MIT"></a>
</p>

Library provides a placeholder implementation for currying functions,
partial applications, pipe operator, and other syntactic structures 
hat allow specifying default values.

## Usage

What is "placeholder"?

```php
<?php

var_dump(is_placeholder('_'));
// expected output: false

var_dump(is_placeholder(_));
// expected output: true

```

For example we can replace each of the placeholders in 
the array with the required value.

```php
<?php
use Serafim\Placeholder\Placeholder;

$array = [1, _, 3, _];

$result = Placeholder::map($array, fn() => ' map ');

echo implode(', ', $result);

// expected output: "1, map, 3, map"
```

And... Thats all =)
