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
 * @mixin callable
 */
interface CurriedFunctionInterface extends Invokable, Renderable, \Countable
{
    /**
     * Returns {@see true} if there are enough arguments to invoke the function
     * or {@see false} instead.
     *
     * @return bool
     */
    public function isCompleted(): bool;

    /**
     * Converts a partially applied function into a \Closure
     *
     * @return \Closure
     */
    public function toClosure(): \Closure;

    /**
     * Returns a function from a function to which you can partially
     * apply the required arguments from left to right.
     *
     * @param mixed ...$args Set of arguments for left currying
     * @return $this Returns a partially applied function
     */
    public function lcurry(...$args): self;

    /**
     * Returns a function from a function to which you can partially
     * apply the required arguments from right to left.
     *
     * @param mixed ...$args Set of arguments for right currying
     * @return $this Returns a partially applied function
     */
    public function rcurry(...$args): self;

    /**
     * An alias of {@see CurriedFunctionInterface::lcurry()} method.
     *
     * @param mixed ...$args
     * @return $this
     */
    public function curry(...$args): self;

    /**
     * @param mixed ...$args
     * @return mixed|static
     */
    public function __invoke(...$args);
}
