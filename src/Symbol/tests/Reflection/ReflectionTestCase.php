<?php
/**
 * This file is part of Symbol package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
declare(strict_types=1);

namespace Serafim\Symbol\Tests\Reflection;

use Serafim\Symbol\ReflectionSymbol;
use Serafim\Symbol\Symbol;
use Serafim\Symbol\Tests\TestCase;

/**
 * Class ReflectionTestCase
 */
abstract class ReflectionTestCase extends TestCase
{
    /**
     * @return array
     */
    public function invalidSymbolTypesDataProvider(): array
    {
        return [
            'string'   => ['symbol'],
            'null'     => [null],
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
    public function dataProvider(): array
    {
        $name = \base64_encode(\random_bytes(32));

        return [
            'local'  => [Symbol::create($name), $name, __LINE__, false],
            'global' => [Symbol::for($name), $name, __LINE__, true],
        ];
    }

    /**
     * @dataProvider dataProvider
     *
     * @param $symbol
     * @return void
     */
    public function testReflectionCreatable($symbol): void
    {
        $this->expectNotToPerformAssertions();

        $this->reflection($symbol);
    }

    /**
     * @param mixed $symbol
     * @return \Serafim\Symbol\ReflectionSymbol
     */
    abstract protected function reflection($symbol): ReflectionSymbol;

    /**
     * @dataProvider invalidSymbolTypesDataProvider
     *
     * @param $haystack
     * @return void
     */
    public function testReflectionThrowsErrorOnInvalidType($haystack): void
    {
        $this->expectInvalidArgumentError($this->method(), 'symbol');

        $this->reflection($haystack);
    }

    /**
     * @return string
     */
    abstract protected function method(): string;

    /**
     * @dataProvider dataProvider
     *
     * @param mixed $symbol
     * @param string $name
     * @return void
     * @throws \PHPUnit\Framework\ExpectationFailedException
     */
    public function testName($symbol, string $name): void
    {
        $reflection = $this->reflection($symbol);

        $this->assertSame($name, $reflection->getName());
    }

    /**
     * @dataProvider dataProvider
     *
     * @param mixed $symbol
     * @return void
     * @throws \PHPUnit\Framework\ExpectationFailedException
     */
    public function testFileName($symbol): void
    {
        $reflection = $this->reflection($symbol);

        $this->assertSame(__FILE__, $reflection->getFileName());
    }

    /**
     * @dataProvider dataProvider
     *
     * @param mixed $symbol
     * @param string $_
     * @param int $line
     * @return void
     * @throws \PHPUnit\Framework\ExpectationFailedException
     */
    public function testStartLine($symbol, string $_, int $line): void
    {
        $reflection = $this->reflection($symbol);

        $this->assertSame($line, $reflection->getStartLine());
    }

    /**
     * @dataProvider dataProvider
     *
     * @param mixed $symbol
     * @param mixed $_
     * @param int $line
     * @return void
     * @throws \PHPUnit\Framework\ExpectationFailedException
     */
    public function testEndLine($symbol, $_, int $line): void
    {
        $reflection = $this->reflection($symbol);

        $this->assertSame($line, $reflection->getEndLine());
    }

    /**
     * @dataProvider dataProvider
     *
     * @param mixed $symbol
     * @param string $name
     * @return void
     * @throws \PHPUnit\Framework\ExpectationFailedException
     */
    public function testRenderable($symbol, string $name): void
    {
        $reflection = $this->reflection($symbol);

        $this->assertSame('Symbol(' . $name . ')', (string)$reflection);
    }

    /**
     * @dataProvider dataProvider
     *
     * @param mixed $symbol
     * @param mixed $_
     * @param mixed $__
     * @param bool $isGlobal
     * @return void
     * @throws \PHPUnit\Framework\ExpectationFailedException
     */
    public function testIsGlobal($symbol, $_, $__, bool $isGlobal): void
    {
        $reflection = $this->reflection($symbol);

        $this->assertSame($isGlobal, $reflection->isGlobal());
    }

    /**
     * @dataProvider dataProvider
     *
     * @param mixed $symbol
     * @param mixed $_
     * @param mixed $__
     * @param bool $isGlobal
     * @return void
     * @throws \PHPUnit\Framework\ExpectationFailedException
     */
    public function testModifiers($symbol, $_, $__, bool $isGlobal): void
    {
        $reflection = $this->reflection($symbol);

        $this->assertSame(
            $isGlobal ? ReflectionSymbol::IS_GLOBAL : 0,
            $reflection->getModifiers()
        );
    }

    /**
     * @dataProvider dataProvider
     *
     * @param mixed $symbol
     * @param string $name
     * @return void
     * @throws \PHPUnit\Framework\ExpectationFailedException
     */
    public function testDebuggable($symbol, string $name): void
    {
        $reflection = $this->reflection($symbol);

        \ob_start();
        \var_dump($reflection);

        $expects =
            '/class %s#\d+ \(\d+\) \{\n' .
            '  public \$name =>\n' .
            '  string\(\d+\) "%s"\n' .
            '\}$/';

        $expects = \vsprintf($expects, [
            \preg_quote(ReflectionSymbol::class, '/'),
            \preg_quote($name, '/'),
        ]);

        $this->assertRegExp($expects, \ob_get_clean());
    }

    /**
     * @dataProvider invalidSymbolTypesDataProvider
     *
     * @param mixed $haystack
     * @return void
     * @throws \ReflectionException
     */
    public function testExportWithInvalidValue($haystack): void
    {
        $this->expectInvalidArgumentError(ReflectionSymbol::class . '::export', 'symbol');

        ReflectionSymbol::export($haystack);
    }

    /**
     * @dataProvider dataProvider
     *
     * @param mixed $symbol
     * @return void
     * @throws \PHPUnit\Framework\Exception
     * @throws \PHPUnit\Framework\ExpectationFailedException
     * @throws \ReflectionException
     */
    public function testExportWithPrint($symbol): void
    {
        \ob_start();
        $result = ReflectionSymbol::export($symbol);

        $this->assertIsString(\ob_get_clean());
        $this->assertNull($result);
    }

    /**
     * @dataProvider dataProvider
     *
     * @param mixed $symbol
     * @return void
     * @throws \PHPUnit\Framework\Exception
     * @throws \PHPUnit\Framework\ExpectationFailedException
     * @throws \ReflectionException
     */
    public function testExportWithReturn($symbol): void
    {
        \ob_start();
        $result = ReflectionSymbol::export($symbol, true);

        $this->assertIsString($stdout = \ob_get_clean());
        $this->assertSame('', $stdout);

        $this->assertIsString($result);
    }
}
