<?php

/**
 * This file is part of phpfn package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Fun\Symbol;

class TypeError extends \TypeError
{
    /**
     * @var string
     */
    public const INVALID_ARGUMENT_FORMAT = 'Argument %d passed to %s() must be of the type %s, %s given';

    /**
     * @var int
     */
    public const INVALID_ARGUMENT_CODE = 0x00;

    /**
     * @var string
     */
    public const EMPTY_NAME_FORMAT = 'Symbol name can not be empty';

    /**
     * @var int
     */
    public const EMPTY_NAME_CODE = 0x01;

    /**
     * @param string $method
     * @param string $type
     * @param string $given
     * @param int $argument
     * @return TypeError
     */
    public static function invalidArgument(string $method, string $type, string $given, int $argument = 1): self
    {
        $message = \sprintf(static::INVALID_ARGUMENT_FORMAT, $argument, $method, $type, $given);

        return new static($message, static::INVALID_ARGUMENT_CODE);
    }

    /**
     * @return TypeError
     */
    public static function emptyName(): self
    {
        return new static(static::EMPTY_NAME_FORMAT, static::EMPTY_NAME_CODE);
    }
}
