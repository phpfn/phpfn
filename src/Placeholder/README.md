# Placeholder


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
use Fun\Placeholder\Placeholder;

$array = [1, _, 3, _];

$result = Placeholder::map($array, fn() => ' map ');

echo implode(', ', $result);

// expected output: "1, map, 3, map"
```

And... Thats all =)
