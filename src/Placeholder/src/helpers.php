<?php
/**
 * This file is part of Placeholder package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
declare(strict_types=1);


use Serafim\Placeholder\Placeholder;
use Serafim\Symbol\Symbol;

//
// Register a global placeholder definition
//
if (! \defined('_')) {
    \define('_', Symbol::for(Placeholder::class));
}


if (! \function_exists('is_placeholder')) {
    /**
     * @param mixed $value
     * @return bool
     */
    function is_placeholder($value): bool
    {
        return Placeholder::match($value);
    }
}
