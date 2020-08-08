<?php

/**
 * This file is part of phpfn package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Fun\Symbol;

/**
 * Interface FactoryInterface
 */
interface FactoryInterface
{
    /**
     * @param string|null $name
     * @return mixed
     */
    public static function create(string $name = null);

    /**
     * @param mixed|resource $symbol
     * @return string
     */
    public static function key($symbol): string;

    /**
     * @param string $name
     * @return mixed
     */
    public static function for(string $name);

    /**
     * @param mixed|resource $symbol
     * @return string|null
     */
    public static function keyFor($symbol): ?string;

    /**
     * @param mixed|resource $symbol
     * @return ReflectionSymbol
     */
    public static function getReflection($symbol): ReflectionSymbol;
}
