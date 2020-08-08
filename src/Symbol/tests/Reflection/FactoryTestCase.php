<?php

/**
 * This file is part of phpfn package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Fun\Symbol\Tests\Reflection;

use Fun\Symbol\ReflectionSymbol;
use Fun\Symbol\Symbol;

/**
 * Class FactoryTestCase
 */
class FactoryTestCase extends ReflectionTestCase
{
    /**
     * @param mixed $symbol
     * @return \Serafim\Symbol\ReflectionSymbol
     * @throws \ReflectionException
     */
    protected function reflection($symbol): ReflectionSymbol
    {
        return Symbol::getReflection($symbol);
    }

    /**
     * @return string
     */
    protected function method(): string
    {
        return Symbol::class . '::getReflection';
    }
}
