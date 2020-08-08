<?php
/**
 * This file is part of Symbol package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
declare(strict_types=1);

namespace Serafim\Symbol\Tests\Names;

use Serafim\Symbol\Tests\TestCase;
use Serafim\Symbol\TypeError;

/**
 * Class NamesTestCase
 */
abstract class NamesTestCase extends TestCase
{
    /**
     * @return array
     */
    public function invalidNamesDataProvider(): array
    {
        return [
            // strings and nulls are correct values
            'int'      => [42],
            'float'    => [.42],
            'bool'     => [true],
            'array'    => [[42]],
            'object'   => [new \StdClass()],
            'resource' => [\fopen('php://memory', 'rb')],
        ];
    }

    /**
     * @return array
     * @throws \Exception
     */
    public function validNamesDataProvider(): array
    {
        $result = [];

        foreach (\range(1, 10) as $i) {
            $i *= 20;

            $result['Length ' . $i] = [\base64_encode(\random_bytes($i))];
        }

        return $result;
    }

    /**
     * @return void
     */
    abstract public function testWithoutName(): void;

    /**
     * @return void
     */
    abstract public function testEmptyName(): void;

    /**
     * @dataProvider validNamesDataProvider
     *
     * @param string|null $name
     * @return void
     */
    abstract public function testValidName(string $name): void;

    /**
     * @dataProvider invalidNamesDataProvider
     *
     * @param string|null $name
     * @return void
     */
    abstract public function testInvalidName($name): void;

    /**
     * @return void
     */
    protected function expectEmptyNameError(): void
    {
        $this->expectException(TypeError::class);
        $this->expectException(\TypeError::class);
        $this->expectExceptionCode(TypeError::EMPTY_NAME_CODE);

        $this->expectExceptionMessage('Symbol name can not be empty');
    }
}
