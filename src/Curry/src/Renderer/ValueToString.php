<?php

/**
 * This file is part of phpfn package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Fun\Curry\Renderer;

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

        return \implode(', ', $this->iteratorMap($map, $argument));
    }

    /**
     * Method returns an array containing all the elements of
     * $iterable after applying the callback function to each one.
     *
     * The number of parameters that the callback function accepts should
     * match the number of iterable arguments passed to the iterator_map()
     *
     * @param callable $map Callback function to run for each element in each iterable.
     * @param iterable ...$iterable An iterable items to run through the callback function.
     * @return array
     */
    private function iteratorMap(callable $map, iterable ...$iterable): array
    {
        $result = [];

        foreach ($iterable as $it) {
            foreach ($it as $key => $value) {
                $result[] = $map($value, $key);
            }
        }

        return $result;
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
