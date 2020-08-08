<?php
/**
 * This file is part of Placeholder package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
declare(strict_types=1);

use Serafim\Symbol\Symbol;

if (! \function_exists('symbol')) {
    /**
     * @param string|null $name
     * @return mixed
     */
    function symbol(string $name = null)
    {
        return Symbol::create($name);
    }
}


if (! \function_exists('is_symbol')) {
    /**
     * @param resource|mixed $symbol
     * @return bool
     */
    function is_symbol($symbol): bool
    {
        return Symbol::isSymbol($symbol);
    }
}
