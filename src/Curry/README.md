# Curry

Convenient implementation of function 
currying and partial application.

- [Installation](#installation)
- [Usage](#usage)
    - [Left currying](#left-currying)
    - [Right currying](#right-currying)
    - [Partial application](#partial-application)
- [Api](#api)
    - [Functions](#functions)
    - [Methods of the curried function](#curried)
    

## Installation

To install the package, use [Composer](https://getcomposer.org/doc/) 
(Or [The Force](https://www.youtube.com/watch?v=o2we_B6hDrY) for the Jedi Developers).

```bash
composer require serafim/curry
```

## Usage

### Left currying

The left currying can be perceived as adding arguments to an array. 
And then applying this array of arguments to the function.


The left currying returns the partially applied function 
from the first argument.

```php
$fn = \curry(function($a, $b) { return $a + $b; });

$fn(3);      // ($a = 3) + ($b = ?)
$fn(3)(4);   // ($a = 3) + ($b = 4)
```

### Right currying

At the same time, right-hand currying can be 
perceived as adding arguments to the right.

```php
$fn = \rcurry(function($a, $b) { return $a + $b; });

$fn(3);      // ($a = ?) + ($b = 3)
$fn(3)(4);   // ($a = 4) + ($b = 3)
```

### Partial application

Partial application is when you can specify completely 
random arguments, skipping unnecessary using placeholder `_`.

```php
$fn = \curry(function($a, $b, $c) { return $a + $b * $c; });

$fn = $fn(_, 3, 4); // ($a = ?)  + ($b = 3) * ($c = 4)
echo  $fn(42);      // ($a = 42) + ($b = 3) * ($c = 4)
```

```php
$fn = \curry(function($a, $b, $c) { return $a + $b * $c; });

$fn = $fn(_, 3, _); // ($a = ?)  + ($b = 3) * ($c = ?)
$fn->lcurry(42);    // ($a = 42) + ($b = 3) * ($c = ?)
$fn->rcurry(23);    // ($a = ?)  + ($b = 3) * ($c = 23)
```

```php
$fn = \curry(function($a, $b, $c) { return $a + $b * $c; });

$sum  = $fn(7, 9);    // 7 + 9 * ?
$sum(6);              // 7 + 9 * 6 

$mul  = $fn(_, 7, 9); // ? + 7 * 9
$mul(6);              // 6 + 7 * 9

$test = $fn(_, 7, _); // ? + 7 * ?
$test(6);             // 6 + 7 * ? 

$test = $fn(_, 7);    // ? + 7 * ?
$test->rcurry(6);     // ? + 7 * 6 
```

## Api

### Functions

- `lcurry(callable $fn, ...$args): Curried` or `curry`
> Left currying (like array_push arguments)

- `rcurry(callable $fn, ...$args): Curried` 
> Right currying

- `uncurry(callable $fn): mixed`
> Returns result or partially applied function


### Curried

- `$fn->__invoke(...$args)` or `$fn(...$args)`
> The magic method that allows an object to a callable type

- `$fn->lcurry(...$args)`
> A method that returns a new function with left currying

- `$fn->rcurry(...$args)`
> A method that returns a new function with right currying

- `$fn->reduce()`
> Reduction of the composition of functions. Those. bringing the function to a single value - the result of this function.

- `$fn->uncurry()`
> An attempt is made to reduce, or bring the function to another, which will return the result

- `$fn->__toString()`
> Just a function dump
