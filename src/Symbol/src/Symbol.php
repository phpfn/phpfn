<?php

/**
 * This file is part of phpfn package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Fun\Symbol;

use Fun\Symbol\Exception\TypeError;

final class Symbol implements FactoryInterface
{
    /**
     * @var string
     */
    private const ERROR_OPEN = 'Cannot create a symbol, php://memory stream is not accessible';

    /**
     * @var string
     */
    private const ANONYMOUS = 'symbol@anonymous#%d';

    /**
     * @var Symbol|null
     */
    private static ?self $instance = null;

    /**
     * @var array|resource[]|mixed[]
     */
    private array $registry = [];

    /**
     * Symbol constructor.
     */
    private function __construct()
    {
        // Close constructor
    }

    /**
     * @param string $name
     * @return mixed
     */
    public static function for(string $name)
    {
        if ($name === '') {
            throw TypeError::emptyName();
        }

        $instance = self::instance();

        if (! \array_key_exists($name, $instance->registry)) {
            $instance->registry[$name] = self::create($name);
        }

        return $instance->registry[$name];
    }

    /**
     * @return Symbol
     */
    private static function instance(): self
    {
        return self::$instance ?? self::$instance = new self();
    }

    /**
     * @param string|null $name
     * @return mixed
     */
    public static function create(string $name = null)
    {
        if ($name === '') {
            throw TypeError::emptyName();
        }

        $resource = @\fopen('php://memory', 'rb');

        if (! Metadata::isStream($resource)) {
            throw new \LogicException(self::ERROR_OPEN);
        }

        Metadata::write($resource, self::resolveName($resource, $name));

        return $resource;
    }

    /**
     * @param resource $resource
     * @param string|null $name
     * @return string
     */
    private static function resolveName($resource, string $name = null): string
    {
        return $name ?: \sprintf(self::ANONYMOUS, $resource);
    }

    /**
     * @param mixed|resource $symbol
     * @return string|null
     */
    public static function keyFor($symbol): ?string
    {
        self::assertIsSymbol($symbol, __METHOD__);

        [$name, $instance] = [self::key($symbol), self::instance()];

        $exists = \array_key_exists($name, $instance->registry);

        return $exists && $instance->registry[$name] === $symbol
            ? $name
            : null;
    }

    /**
     * @param resource|mixed $symbol
     * @param string $method
     * @return void
     */
    private static function assertIsSymbol($symbol, string $method): void
    {
        if (! self::isSymbol($symbol)) {
            throw TypeError::invalidArgument($method, 'symbol', \gettype($symbol));
        }
    }

    /**
     * @param mixed $symbol
     * @return bool
     */
    public static function isSymbol($symbol): bool
    {
        if (! Metadata::isStream($symbol)) {
            return false;
        }

        return Metadata::exists($symbol);
    }

    /**
     * @param resource|mixed $symbol
     * @return string
     */
    public static function key($symbol): string
    {
        self::assertIsSymbol($symbol, __METHOD__);

        /** @noinspection NullPointerExceptionInspection */
        return Metadata::read($symbol)->getName();
    }

    /**
     * @param resource|mixed $symbol
     * @return ReflectionSymbol
     * @throws \ReflectionException
     */
    public static function getReflection($symbol): ReflectionSymbol
    {
        self::assertIsSymbol($symbol, __METHOD__);

        return new ReflectionSymbol($symbol);
    }

    /**
     * @return void
     */
    public function __wakeup(): void
    {
        throw new \LogicException(\sprintf('Deserialization of %s is not allowed', __CLASS__));
    }

    /**
     * @return void
     */
    private function __clone()
    {
        throw new \LogicException(\sprintf('Clone of %s is not allowed', __CLASS__));
    }
}
