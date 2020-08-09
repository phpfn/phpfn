# Immutable

## Installation

Library can be installed into any PHP application:
- Using [`Composer`](https://getcomposer.org/) dependency manager 
- [The Force](https://www.youtube.com/watch?v=o2we_B6hDrY) for the Jedi Developers

```sh
$ composer require phpfn/immutable
```

In order to access library make sure to include `vendor/autoload.php` 
in your file.

```php
<?php

require __DIR__ . '/vendor/autoload.php';
```

## Usage

To ensure immunity of objects, you just need to wrap any code of your method in 
a closure.

Mutable object example:

```php
class Example
{
    private int $value = 42;

    public function update(int $newValue): self
    {
        $this->value = $newValue;
    
        return $this;
    }
}
```

Making it immutable:

```php
class Example
{
    private int $value = 42;

    // Sample #1 (PHP 7.4+)
    public function with(int $newValue): self
    {
        return immutable(fn () => $this->value = $newValue);
    }
}
```

That`s all!
