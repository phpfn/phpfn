<?php

/**
 * This file is part of phpfn package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

use Fun\Immutable\Immutable;

if (! function_exists('immutable')) {
    /**
     * @template T of object
     * @param Closure $expr
     * @param T|null $context
     * @return T
     */
    function immutable(\Closure $expr, object $context = null): object
    {
        return Immutable::make($expr, $context);
    }
}
