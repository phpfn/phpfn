<?php

/**
 * This file is part of phpfn package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Fun\Immutable\Exception;

/**
 * An error occurs when it is impossible to ensure the integrity
 * and immutability of an object.
 *
 * For example it can be thrown in case of cloning any \Throwable object
 * or other system object.
 */
class IntegrityException extends \LogicException
{

}
