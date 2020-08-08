<?php
/**
 * This file is part of Curry package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
declare(strict_types=1);

namespace Serafim\Curry\Renderer;

/**
 * Trait ValueToString
 */
trait ValueToString
{
    /**
     * @param float|int|string|bool $argument
     * @return string
     */
    private function scalarToString($argument): string
    {
        return (string)$argument;
    }

    /**
     * @param iterable $argument
     * @return string
     */
    private function iteratorToString(iterable $argument): string
    {
        $map = function ($item): string {
            return $this->valueToString($item, false);
        };

        return \implode(', ', \iterator_map($map, $argument));
    }

    /**
     * @param object $argument
     * @return string
     */
    private function objectToString($argument): string
    {
        $class = \basename(\str_replace('\\', '/', \get_class($argument)));

        return \sprintf('object(%s)#%d', $class, \spl_object_id($argument));
    }

    /**
     * @param resource $argument
     * @return string
     */
    private function resourceToString($argument): string
    {
        return \sprintf('resource(#%d)', $argument);
    }

    /**
     * @param callable $argument
     * @return string
     */
    private function callableToString(callable $argument): string
    {
        $pattern = '(%s => {})';

        if (\is_object($argument)) {
            return \sprintf($pattern, $this->objectToString($argument));
        }

        if (\is_array($argument)) {
            return \sprintf($pattern, $this->iteratorToString($argument));
        }

        if (\is_string($argument)) {
            return \sprintf($pattern, $argument);
        }

        return \sprintf($pattern, \mb_strtolower(\gettype($argument)));
    }

    /**
     * @param $argument
     * @param bool $deep
     * @return string
     */
    private function valueToString($argument, bool $deep = true): string
    {
        if (\is_scalar($argument)) {
            return $this->scalarToString($argument);
        }

        if (\is_iterable($argument)) {
            return $deep ? '[' . $this->iteratorToString($argument) . ']' : '';
        }

        if (\is_callable($argument)) {
            return $this->callableToString($argument);
        }

        if (\is_object($argument)) {
            return $this->objectToString($argument);
        }

        if (\is_resource($argument)) {
            return $this->resourceToString($argument);
        }

        return '?';
    }

    /**
     * @param mixed ...$arguments
     * @return string
     */
    protected function getArguments(...$arguments): string
    {
        $result = [];

        foreach ($arguments as $argument) {
            $result[] = $this->valueToString($argument);
        }

        return \implode(', ', $result);
    }
}
