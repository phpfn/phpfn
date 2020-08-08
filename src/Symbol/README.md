# Symbol

Symbol is a special primitive data type, indicating an unique identifier. 
This `symbol` library implementation is similar to alternative types in:

1) Symbols in JavaScript: [https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Symbol](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Symbol)
2) Symbols in Ruby: [https://ruby-doc.org/core-2.5.0/Symbol.html](https://ruby-doc.org/core-2.5.0/Symbol.html)
3) Symbols in TypeScript: [https://www.typescriptlang.org/docs/handbook/symbols.html](https://www.typescriptlang.org/docs/handbook/symbols.html)
4) Atoms in Erlang: [http://erlang.org/doc/reference_manual/data_types.html#atom](http://erlang.org/doc/reference_manual/data_types.html#atom)
5) ...e.g.

## Installation

Library can be installed into any PHP application:
- Using [`Composer`](https://getcomposer.org/) dependency manager 
- [The Force](https://www.youtube.com/watch?v=o2we_B6hDrY) for the Jedi Developers

```sh
$ composer require phpfn/symbol
```

In order to access library make sure to include `vendor/autoload.php` 
in your file.

```php
<?php

require __DIR__ . '/vendor/autoload.php';
```


## Usage

In order to create a new symbol data type, you should use 
the `Symbol::create()` method or call the global `symbol()` 
helper function.

```php
<?php

$a = symbol();

// OR

$b = \Fun\Symbol\Symbol::create();

```

#### Names

Each symbol can have a name (description), 
which is passed as the first parameter.

```php
<?php

$symbol = symbol('id');

```

#### Uniqueness

Please note that the symbols are **unique** regardless 
of the names.

```php
<?php

var_dump(symbol() === symbol()); 
// expected output: false

var_dump(symbol('example') === symbol('example')); 
// expected output: false

```

#### Usage In Constants

Symbols can be used as variable values and even constant!

```php
<?php

define('EXAMPLE', symbol());

var_dump(is_symbol(EXAMPLE));
// expected output: true

class Example
{
    public const CLASS_CONST = EXAMPLE;
}

var_dump(is_symbol(Example::CLASS_CONST));
// expected output: true

```

#### Serialization

However cannot be serialized:

```php
<?php

serialize(symbol());
// Error
```

#### Type Comparison

Notice that the symbols are neither a string, nor a number, nor anything (almost :3) else.

```php
<?php

var_dump(is_string(symbol()));
// expected output: false

var_dump(is_int(symbol()));
// expected output: false

var_dump(is_float(symbol()));
// expected output: false

var_dump(is_bool(symbol()));
// expected output: false

var_dump(is_array(symbol()));
// expected output: false

var_dump(is_object(symbol()));
// expected output: false

var_dump(is_null(symbol()));
// expected output: false

var_dump(is_symbol(symbol()));
// expected output: true

var_dump(is_resource(symbol()));
// expected output: true
```

#### Clone

Note that symbols are always passed by reference and cloning not allowed.

```php
<?php

$a = symbol();
$b = $a;

var_dump($a === $b);
// expected output: true

var_dump(clone $a);
// Error

```

#### Naming

And in order to get the name of a symbol, 
just use the `Symbol::key()` method:

```php
<?php
use Fun\Symbol\Symbol;

var_dump(Symbol::key(symbol('hello')));
// expected output: "hello"

var_dump(Symbol::key(symbol('hello')) === Symbol::key(symbol('hello')));
// expected output: true

var_dump(symbol('hello') === symbol('hello'));
// expected output: false
```

#### Reflection

And you can find out some details about this type:

```php
<?php

use Fun\Symbol\Symbol;

$reflection = Symbol::getReflection(Symbol::create('hello'));

$reflection->getName();      // Contains "hello" string
$reflection->getFileName();  // Provides path/to/file-with-symbol-definition.php
$reflection->getStartLine(); // Provides definition line

// etc...
 
```

#### Global Symbols

In addition to all this, you can use the `Symbol::for` method to create 
a global symbol. The `Symbol::for($key)` method searches for existing symbols 
in a runtime-wide symbol registry with the given key and returns it if 
found. Otherwise a new symbol gets created in the global symbol registry 
with this key.

```php
<?php

use Fun\Symbol\Symbol;

var_dump(Symbol::for('a') === Symbol::for('a'));
// expected output: true

var_dump(Symbol::create('a') === Symbol::for('a'));
// expected output: false

```

And method `Symbol::keyFor($symbol)` returns a name 
for a global symbol.

```php
<?php

var_dump(Symbol::keyFor(Symbol::for('a')));
// expected output: "a"

var_dump(Symbol::keyFor(Symbol::create('a')));
// expected output: null
```
