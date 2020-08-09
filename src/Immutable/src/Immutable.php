<?php

/**
 * This file is part of phpfn package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Fun\Immutable;

use Fun\Immutable\Exception\ContextException;
use Fun\Immutable\Exception\IntegrityException;

final class Immutable
{
    /**
     * @var string
     */
    private const ERROR_LOST_CONTEXT =
        'Can not create an immutable object, because \Closure ' .
        'argument does not contain the context. Make sure the \Closure is ' .
        'not static and/or used inside an object';

    /**
     * @deprecated Please use {@see Immutable::make()} function instead.
     *
     * @param \Closure $expr
     * @param object|null $context
     * @return object
     */
    public static function execute(\Closure $expr, object $context = null): object
    {
        return self::make($expr, $context);
    }

    /**
     * @psalm-param \Closure(): void $callable
     *
     * @param \Closure $expr
     * @param object|null $context
     * @return object
     */
    public static function make(\Closure $expr, object $context = null): object
    {
        $context = self::resolveContext($expr, $context);

        try {
            $self = clone $context;
        } catch (\Throwable $e) {
            throw new IntegrityException($e->getMessage(), 0x01);
        }

        $expr->call($self);

        return $self;
    }

    /**
     * @param \Closure $callable
     * @param object|null $context
     * @return object
     */
    private static function resolveContext(\Closure $callable, object $context = null): object
    {
        try {
            /** @var object|null $context */
            $context = $context ?? (new \ReflectionFunction($callable))->getClosureThis();
        } catch (\ReflectionException $e) {
            throw new ContextException($e->getMessage(), 0x01);
        }

        if ($context === null) {
            throw new ContextException(self::ERROR_LOST_CONTEXT, 0x02);
        }

        return $context;
    }
}
