<?php

/**
 * This file is part of phpfn package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Fun\Curry;

interface FactoryInterface
{
    /**
     * @param callable|\ReflectionFunctionAbstract $callable
     * @return CurriedFunctionInterface
     */
    public static function new($callable): CurriedFunctionInterface;

    /**
     * @param \Closure $callable
     * @return CurriedFunctionInterface
     */
    public static function fromClosure(\Closure $callable): CurriedFunctionInterface;

    /**
     * @param callable $callable
     * @return CurriedFunctionInterface
     */
    public static function fromCallable(callable $callable): CurriedFunctionInterface;

    /**
     * @param \ReflectionMethod $func
     * @return CurriedFunctionInterface
     */
    public static function fromReflectionMethod(\ReflectionMethod $func): CurriedFunctionInterface;

    /**
     * @param \ReflectionFunction $func
     * @return CurriedFunctionInterface
     */
    public static function fromReflectionFunction(\ReflectionFunction $func): CurriedFunctionInterface;
}
