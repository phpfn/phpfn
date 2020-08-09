<?php

/**
 * This file is part of phpfn package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Fun\Immutable\Tests;

use PHPUnit\Framework\TestCase;
use Fun\Immutable\Immutable;

class IntegrityTestCase extends TestCase
{
    /**
     * @var int
     */
    private int $value = 42;

    /**
     * @return void
     */
    public function testObjectIsCopy(): void
    {
        $self = Immutable::make(function () {
            $this->value = 23;
        });

        $this->assertNotSame($this, $self, 'Immutable object should be the same');
    }

    /**
     * @return void
     */
    public function testValueHasBeenChanged(): void
    {
        $self = Immutable::make(function () {
            $this->value = 23;
        });

        $this->assertNotSame($this->value, $self->value, 'Value of new object should be changed');
    }

    /**
     * @return void
     */
    public function testChangedValues(): void
    {
        $self = Immutable::make(function () {
            $this->value = 23;
        });

        $this->assertSame($this->value, 42, 'Old value should be equal with 42');
        $this->assertSame($self->value, 23, 'New value should be equal with 23');
    }
}
