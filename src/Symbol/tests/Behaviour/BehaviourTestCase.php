<?php

/**
 * This file is part of phpfn package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Fun\Symbol\Tests\Behaviour;

use Fun\Symbol\Symbol;
use Fun\Symbol\Tests\TestCase;
use PHPUnit\Framework\ExpectationFailedException;

abstract class BehaviourTestCase extends TestCase
{
    /**
     * @return void
     * @throws ExpectationFailedException
     */
    public function testIsUniqueAfterGlobal(): void
    {
        $a = Symbol::for('global-0');
        $b = Symbol::create('a');

        $this->assertNotSame($a, $b);
    }

    /**
     * @return void
     * @throws ExpectationFailedException
     */
    public function testIsUniqueBeforeGlobal(): void
    {
        $b = Symbol::create('a');
        $a = Symbol::for('global-0');

        $this->assertNotSame($a, $b);
    }
}
