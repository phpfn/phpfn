<?php
/**
 * This file is part of Symbol package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
declare(strict_types=1);

namespace Serafim\Symbol\Tests\Behaviour;

use Serafim\Symbol\Symbol;
use Serafim\Symbol\Tests\TestCase;

/**
 * Class BehaviourTestCase
 */
abstract class BehaviourTestCase extends TestCase
{
    /**
     * @return void
     * @throws \PHPUnit\Framework\ExpectationFailedException
     */
    public function testIsUniqueAfterGlobal(): void
    {
        $a = Symbol::for('global-0');
        $b = Symbol::create('a');

        $this->assertNotSame($a, $b);
    }

    /**
     * @return void
     * @throws \PHPUnit\Framework\ExpectationFailedException
     */
    public function testIsUniqueBeforeGlobal(): void
    {
        $b = Symbol::create('a');
        $a = Symbol::for('global-0');

        $this->assertNotSame($a, $b);
    }
}
