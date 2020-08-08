<?php
/**
 * This file is part of Symbol package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
declare(strict_types=1);

namespace Serafim\Symbol\Tests\Names;

use Serafim\Symbol\Symbol;

/**
 * Class GlobalSymbolNamesTestCase
 */
class GlobalSymbolNamesTestCase extends NamesTestCase
{
    /**
     * @return void
     */
    public function testWithoutName(): void
    {
        $this->expectInvalidArgumentError(Symbol::class . '::for', 'string');

        Symbol::for(null);
    }

    /**
     * @return void
     */
    public function testEmptyName(): void
    {
        $this->expectEmptyNameError();

        Symbol::for('');
    }

    /**
     * @dataProvider validNamesDataProvider
     *
     * @param string $name
     * @return void
     * @throws \PHPUnit\Framework\ExpectationFailedException
     * @throws \PHPUnit\Framework\Exception
     */
    public function testValidName(string $name): void
    {
        $symbol = Symbol::for($name);

        $this->assertSame($name, Symbol::key($symbol));

        $this->assertIsString(Symbol::keyFor($symbol));
        $this->assertSame($name, Symbol::keyFor($symbol));
    }

    /**
     * @dataProvider invalidNamesDataProvider
     *
     * @param string|null $name
     * @return void
     */
    public function testInvalidName($name): void
    {
        $this->expectInvalidArgumentError(Symbol::class . '::for', 'string');

        Symbol::for($name);
    }
}
