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
 * Class LocalSymbolNamesTestCase
 */
class LocalSymbolNamesTestCase extends NamesTestCase
{
    /**
     * @return void
     * @throws \PHPUnit\Framework\ExpectationFailedException
     */
    public function testWithoutName(): void
    {
        $symbol = Symbol::create(null);

        $this->assertRegExp('/symbol@anonymous#\d+/', Symbol::key($symbol));
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
     * @throws \PHPUnit\Framework\ExpectationFailedException
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
