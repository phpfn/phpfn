<?php

/**
 * This file is part of phpfn package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Fun\Placeholder;

use Fun\Symbol\Symbol;

final class Placeholder
{
    /**
     * @param iterable $items
     * @param \Closure $each
     * @return array
     */
    public static function map(iterable $items, \Closure $each): array
    {
        return \iterator_to_array(self::lazyMap($items, $each));
    }

    /**
     * @param iterable $items
     * @param \Closure $each
     * @return \Traversable
     */
    public static function lazyMap(iterable $items, \Closure $each): \Traversable
    {
        foreach ($items as $key => $value) {
            yield self::match($value) ? $each($key, $items) : $value;
        }
    }

    /**
     * @param mixed $value
     * @return bool
     */
    public static function match($value): bool
    {
        static $placeholder;

        return $value === ($placeholder ?? $placeholder = Symbol::for(self::class));
    }

    /**
     * @param iterable $items
     * @param \Closure|null $filter
     * @return array
     */
    public static function filter(iterable $items, \Closure $filter = null): array
    {
        return \iterator_to_array(self::lazyFilter($items, $filter));
    }

    /**
     * @param iterable $items
     * @param \Closure|null $filter
     * @return \Traversable
     */
    public static function lazyFilter(iterable $items, \Closure $filter = null): \Traversable
    {
        foreach ($items as $key => $value) {
            if (self::match($value) && ($filter === null || $filter($key, $items))) {
                continue;
            }

            yield $value;
        }
    }
}
