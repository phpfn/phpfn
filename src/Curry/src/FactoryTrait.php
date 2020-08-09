<?php

/**
 * This file is part of phpfn package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Fun\Curry;

/**
 * @mixin FactoryInterface
 */
trait FactoryTrait
{
    /**
     * @param \Closure $ctx
     * @param int $arguments
     * @return CurriedFunctionInterface
     */
    abstract protected static function create(\Closure $ctx, int $arguments = 0): CurriedFunctionInterface;

    /**
     * @param callable|\ReflectionFunctionAbstract $callable
     * @return CurriedFunctionInterface
     */
    public static function new($callable): CurriedFunctionInterface
    {
        switch (true) {
            case $callable instanceof \Closure:
                return static::fromClosure($callable);

            case \is_callable($callable):
                return static::fromCallable($callable);

            case $callable instanceof \ReflectionMethod:
                return static::fromReflectionMethod($callable);

            case $callable instanceof \ReflectionFunctionAbstract:
                return static::fromReflectionFunction($callable);
        }

        return static::fromClosure(fn() => $callable);
    }

    /**
     * @param \Closure $callable
     * @return CurriedFunctionInterface
     */
    public static function fromClosure(\Closure $callable): CurriedFunctionInterface
    {
        return static::create($callable, self::arguments($callable));
    }

    /**
     * @param \Closure $callable
     * @return int
     */
    private static function arguments(\Closure $callable): int
    {
        try {
            return (new \ReflectionFunction($callable))->getNumberOfParameters();
        } catch (\ReflectionException $e) {
            return 1;
        }
    }

    /**
     * @param callable $callable
     * @return CurriedFunctionInterface
     */
    public static function fromCallable(callable $callable): CurriedFunctionInterface
    {
        return static::fromClosure(\Closure::fromCallable($callable));
    }

    /**
     * @param \ReflectionMethod $func
     * @return CurriedFunctionInterface
     */
    public static function fromReflectionMethod(\ReflectionMethod $func): CurriedFunctionInterface
    {
        $func->setAccessible(true);

        return static::fromClosure($func->getClosure());
    }

    /**
     * @param \ReflectionFunctionAbstract $func
     * @return CurriedFunctionInterface
     */
    public static function fromReflectionFunction(\ReflectionFunctionAbstract $func): CurriedFunctionInterface
    {
        return static::fromClosure($func->getClosure());
    }
}
