<?php

/**
 * This file is part of phpfn package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Fun\Curry;

use Fun\Curry\Renderer\ClosureRenderer;
use Fun\Curry\Renderer\ValueToString;
use Fun\Placeholder\Placeholder;

final class Curried implements CurriedFunctionInterface, FactoryInterface
{
    use ValueToString;
    use FactoryTrait;

    /**
     * @var \Closure
     */
    private \Closure $context;

    /**
     * @var array
     */
    private array $leftArguments = [];

    /**
     * @var array
     */
    private array $rightArguments = [];

    /**
     * @var int
     */
    private int $maxArguments;

    /**
     * @param \Closure $callable
     * @param int $maxArguments
     */
    private function __construct(\Closure $callable, int $maxArguments = 0)
    {
        $this->context = $callable;
        $this->maxArguments = $maxArguments;
    }

    /**
     * {@inheritDoc}
     */
    public function __invoke(...$args)
    {
        $curried = $this->lcurry(...$args);

        if (\count($args) === 0) {
            return $curried->reduce();
        }

        return $curried;
    }

    /**
     * {@inheritDoc}
     */
    public function lcurry(...$args): self
    {
        $ctx = (clone $this);

        $left = [];

        foreach ($this->leftArguments as $argument) {
            $left[] = $this->isPlaceholder($argument) && \count($args)
                ? \array_shift($args)
                : $argument;
        }

        $ctx->leftArguments = \array_merge($left, $args);

        return $ctx;
    }

    /**
     * @param mixed $value
     * @return bool
     */
    private function isPlaceholder($value): bool
    {
        return Placeholder::match($value);
    }

    /**
     * @return mixed
     */
    public function reduce()
    {
        return ($this->context)(...$this->filter());
    }

    /**
     * @return array
     */
    private function filter(): array
    {
        return Placeholder::filter([...$this->leftArguments, ...$this->rightArguments]);
    }

    /**
     * @return bool
     */
    public function isCompleted(): bool
    {
        return $this->maxArguments <= $this->count();
    }

    /**
     * @return int
     */
    public function count(): int
    {
        return \count($this->filter());
    }

    /**
     * {@inheritDoc}
     */
    public function rcurry(...$args): self
    {
        $ctx = (clone $this);

        $right = [];

        foreach (\array_reverse($this->rightArguments) as $argument) {
            $right[] = $this->isPlaceholder($argument) && \count($args)
                ? \array_pop($args)
                : $argument;
        }

        $ctx->rightArguments = \array_merge(\array_reverse($right), $args);

        return $ctx;
    }

    /**
     * {@inheritDoc}
     */
    public function toClosure(): \Closure
    {
        return function (...$args) {
            return $this->lcurry(...$args)->reduce();
        };
    }

    /**
     * {@inheritDoc}
     */
    public function curry(...$args): self
    {
        return $this->lcurry(...$args);
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        try {
            $renderer = new ClosureRenderer($this->context, $this->leftArguments, $this->rightArguments);
        } catch (\ReflectionException $e) {
            return ClosureRenderer::fallback($this->context);
        }

        return (string)$renderer;
    }

    /**
     * @return array
     */
    public function __debugInfo(): array
    {
        return [
            'context'        => $this->context,
            'leftArguments'  => \array_map([$this, 'valueToString'], $this->leftArguments),
            'rightArguments' => \array_map([$this, 'valueToString'], $this->rightArguments),
        ];
    }

    /**
     * @param \Closure $ctx
     * @param int $arguments
     * @return CurriedFunctionInterface
     */
    protected static function create(\Closure $ctx, int $arguments = 0): CurriedFunctionInterface
    {
        return new self($ctx, $arguments);
    }
}
