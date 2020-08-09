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
use Fun\Symbol\Metadata\Sign;
use Fun\Symbol\Metadata\SignInterface;

/**
 * @internal class for metadata reading and writing.
 */
final class Metadata
{
    /**
     * @var string
     */
    private const TYPE_STREAM = 'stream';

    /**
     * @var string
     */
    private const CONTEXT_WRAPPER = 'php';

    /**
     * @var string
     */
    private const CONTEXT_FIELD_SIGN = '__metadata';

    /**
     * @param resource $resource
     * @param string $method
     * @return void
     */
    private static function assertIsStream($resource, string $method): void
    {
        if (! self::isStream($resource)) {
            throw TypeError::invalidArgument($method, 'stream resource', \gettype($resource));
        }
    }

    /**
     * @param resource $resource
     * @param string $name
     * @return resource
     */
    public static function write($resource, string $name)
    {
        self::assertIsStream($resource, __METHOD__);

        \stream_context_set_option($resource, self::context($name));

        return $resource;
    }

    /**
     * @param resource $resource
     * @return bool
     */
    public static function isStream($resource): bool
    {
        return \is_resource($resource) && \get_resource_type($resource) === self::TYPE_STREAM;
    }

    /**
     * @param string $name
     * @return array
     */
    private static function context(string $name): array
    {
        return [
            self::CONTEXT_WRAPPER => [
                self::CONTEXT_FIELD_SIGN => new Sign($name),
            ],
        ];
    }

    /**
     * @param resource $resource
     * @return SignInterface|null
     */
    public static function read($resource): ?SignInterface
    {
        self::assertIsStream($resource, __METHOD__);

        $options = \stream_context_get_options($resource);

        return $options[self::CONTEXT_WRAPPER][self::CONTEXT_FIELD_SIGN] ?? null;
    }

    /**
     * @param resource $resource
     * @return bool
     */
    public static function exists($resource): bool
    {
        self::assertIsStream($resource, __METHOD__);

        $options = \stream_context_get_options($resource);

        return isset($options[self::CONTEXT_WRAPPER][self::CONTEXT_FIELD_SIGN]);
    }
}
