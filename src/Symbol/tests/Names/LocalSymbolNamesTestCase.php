<?php

/**
 * This file is part of phpfn package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Fun\Symbol\Tests\Names;

use Fun\Symbol\Symbol;
use PHPUnit\Framework\ExpectationFailedException;

class LocalSymbolNamesTestCase extends NamesTestCase
{
    /**
     * @return void
     * @throws ExpectationFailedException
     */
    public function testWithoutName(): void
    {
        $symbol = Symbol::create(null);

        $this->assertMatchesRegularExpression('/symbol@anonymous#\d+/', Symbol::key($symbol));
        $this->assertNull(Symbol::keyFor($symbol));
    }

    /**
     * @return void
     */
    public function testEmptyName(): void
    {
        $this->expectEmptyNameError();

        Symbol::create('');
    }

    /**
     * @dataProvider validNamesDataProvider
     *
     * @param string $name
     * @return void
     * @throws ExpectationFailedException
     */
    public function testValidName(string $name): void
    {
        $symbol = Symbol::create($name);

        $this->assertSame($name, Symbol::key($symbol));
        $this->assertNull(Symbol::keyFor($symbol));
    }

    /**
     * @dataProvider invalidNamesDataProvider
     *
     * @param string|null $name
     * @return void
     */
    public function testInvalidName($name): void
    {
        $this->expectInvalidArgumentError(Symbol::class . '::create', 'string or null');

        Symbol::create($name);
    }
}
