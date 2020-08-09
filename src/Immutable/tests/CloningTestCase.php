<?php

/**
 * This file is part of phpfn package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Fun\Immutable\Tests;

use Fun\Immutable\Exception\IntegrityException;
use Fun\Immutable\Immutable;
use PHPUnit\Framework\TestCase;

class CloningTestCase extends TestCase
{
    /**
     * @return void
     */
    public function testStaticContext(): void
    {
        $this->expectException(IntegrityException::class);
        $this->expectExceptionMessage('Trying to clone an uncloneable object of class class@anonymous');
        $this->expectExceptionCode(1);

        $object = new class extends \Exception {
            public function test(): void
            {
                Immutable::make(function () {
                    throw new \LogicException('This code should not have been executed');
                });
            }
        };

        $object->test();
    }
}
