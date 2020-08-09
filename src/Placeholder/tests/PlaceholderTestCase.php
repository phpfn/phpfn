<?php

/**
 * This file is part of phpfn package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Fun\Placeholder\Tests;

use Fun\Placeholder\Placeholder;
use PHPUnit\Framework\Exception;
use PHPUnit\Framework\ExpectationFailedException;

class PlaceholderTestCase extends TestCase
{
    /**
     * @return void
     * @throws ExpectationFailedException
     * @throws Exception
     */
    public function testMap(): void
    {
        $result = Placeholder::map([1, _, 2, _], fn(): int => 42);

        $this->assertSame([1, 42, 2, 42], $result);
        $this->assertIsArray($result);
    }

    /**
     * @return void
     * @throws ExpectationFailedException
     */
    public function testLazyMap(): void
    {
        $result = Placeholder::lazyMap([1, _, 2, _], fn(): int => 42);

        $this->assertInstanceOf(\Generator::class, $result);
        $this->assertSame([1, 42, 2, 42], \iterator_to_array($result));
    }

    /**
     * @return void
     * @throws ExpectationFailedException
     * @throws Exception
     */
    public function testFilter(): void
    {
        $result = Placeholder::filter([1, _, 2, _]);

        $this->assertSame([1, 2], $result);
        $this->assertIsArray($result);
    }

    /**
     * @return void
     * @throws ExpectationFailedException
     */
    public function testLazyFilter(): void
    {
        $result = Placeholder::lazyFilter([1, _, 2, _]);

        $this->assertInstanceOf(\Generator::class, $result);
        $this->assertSame([1, 2], \iterator_to_array($result));
    }

    /**
     * @return void
     * @throws ExpectationFailedException
     * @throws Exception
     */
    public function testFilterWithCallback(): void
    {
        $result = Placeholder::filter([1, _, 2, _], fn(int $index): bool => $index === 1);

        $this->assertSame([1, 2, _], $result);
        $this->assertIsArray($result);
    }

    /**
     * @return void
     * @throws ExpectationFailedException
     */
    public function testLazyFilterWithCallback(): void
    {
        $result = Placeholder::lazyFilter([1, _, 2, _], fn(int $index): bool => $index === 3);

        $this->assertInstanceOf(\Generator::class, $result);
        $this->assertSame([1, _, 2], \iterator_to_array($result));
    }

    /**
     * @return array
     */
    public function typesDataProvider(): array
    {
        return [
            'string'      => ['is_string', false],
            'null'        => ['is_null', false],
            'int'         => ['is_int', false],
            'float'       => ['is_float', false],
            'bool'        => ['is_bool', false],
            'array'       => ['is_array', false],
            'object'      => ['is_object', false],
            'resource'    => ['is_resource', true],
            'placeholder' => ['is_placeholder', true],
            'symbol'      => ['is_symbol', true],
        ];
    }

    /**
     * @dataProvider typesDataProvider
     *
     * @param callable $fn
     * @param bool $eq
     * @return void
     * @throws ExpectationFailedException
     */
    public function testIsPlaceholder(callable $fn, bool $eq): void
    {
        $this->assertSame($eq, $fn(_));
    }
}
