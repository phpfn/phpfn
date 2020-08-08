<?php

/**
 * This file is part of phpfn package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Fun\Symbol\Metadata;

/**
 * Class Sign
 */
final class Sign implements SignInterface
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var array
     */
    private $context;

    /**
     * Sign constructor.
     *
     * @param string $name
     */
    public function __construct(string $name)
    {
        $this->name = $name;
        $this->context = $this->createContext();
    }

    /**
     * @return array
     */
    private function createContext(): array
    {
        $root = $this->getRootDirectory();

        foreach (\debug_backtrace(\DEBUG_BACKTRACE_IGNORE_ARGS) as $trace) {
            if (isset($trace['file']) && \strpos($trace['file'], $root) !== 0) {
                return $trace;
            }
        }

        return [];
    }

    /**
     * @return string
     */
    private function getRootDirectory(): string
    {
        return \dirname(__FILE__, 2);
    }

    /**
     * @return array
     */
    public function getContext(): array
    {
        return $this->context;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }
}
