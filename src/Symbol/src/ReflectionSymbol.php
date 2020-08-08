<?php

/**
 * This file is part of phpfn package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Fun\Symbol;

/**
 * Class ReflectionSymbol
 */
final class ReflectionSymbol implements \Reflector
{
    /**
     * @var int
     */
    public const IS_GLOBAL = 16;

    /**
     * @var string
     */
    private const ERROR_TYPE = '%s() expects parameter 1 to be a symbol, but %s given';

    /**
     * @var string
     */
    private const EXPORT_FORMAT =
        'Symbol [ <user> %s symbol %s ] {' . \PHP_EOL .
        '  @@ %s %d-%d' . \PHP_EOL .
        '}' . \PHP_EOL;

    /**
     * @var string
     */
    private $name;

    /**
     * @var array
     */
    private $context;

    /**
     * @var mixed|resource
     */
    private $symbol;

    /**
     * ReflectionSymbol constructor.
     *
     * @param mixed|resource $symbol
     * @throws \ReflectionException
     */
    public function __construct($symbol)
    {
        self::assertIsSymbol($symbol, __METHOD__);

        $meta = Metadata::read($symbol);

        $this->symbol = $symbol;

        $this->name = $meta->getName();
        $this->context = $meta->getContext();
    }

    /**
     * @return int
     */
    public function getModifiers(): int
    {
        $modifiers = 0;

        if ($this->isGlobal()) {
            $modifiers += self::IS_GLOBAL;
        }

        return $modifiers;
    }

    /**
     * @return bool
     */
    public function isGlobal(): bool
    {
        return Symbol::keyFor($this->symbol) !== null;
    }

    /**
     * @param mixed $symbol
     * @param string $method
     * @return void
     * @throws \ReflectionException
     */
    private static function assertIsSymbol($symbol, string $method): void
    {
        if (! Symbol::isSymbol($symbol)) {
            $e = TypeError::invalidArgument($method, 'symbol', \gettype($symbol));

            throw new \ReflectionException($e->getMessage(), $e->getCode(), $e);
        }
    }

    /**
     * @param mixed|resource $symbol
     * @param bool $return
     * @return string|void
     * @throws \ReflectionException
     */
    public static function export($symbol, bool $return = false)
    {
        self::assertIsSymbol($symbol, __METHOD__);

        $reflection = new static($symbol, Metadata::read($symbol));

        $result = \vsprintf(self::EXPORT_FORMAT, [
            $reflection->isGlobal() ? 'global' : 'local',
            $reflection->getName(),
            $reflection->getFileName(),
            $reflection->getStartLine(),
            $reflection->getEndLine(),
        ]);

        if ($return) {
            return $result;
        }

        echo $result;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getFileName(): string
    {
        return $this->context['file'] ?? 'unknown';
    }

    /**
     * @return int
     */
    public function getStartLine(): int
    {
        return $this->context['line'] ?? 0;
    }

    /**
     * @return int
     */
    public function getEndLine(): int
    {
        return $this->getStartLine();
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return \sprintf('Symbol(%s)', $this->getName());
    }

    /**
     * @return array
     */
    public function __debugInfo(): array
    {
        return [
            'name' => $this->getName(),
        ];
    }
}
