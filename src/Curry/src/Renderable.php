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
 * @deprecated since 2.0 and will be removed in 3.0
 * @see \Stringable please use Stringable interface instead
 */
interface Renderable extends \Stringable
{
    /**
     * @return string
     */
    public function __toString(): string;
}
