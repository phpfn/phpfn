<?php
/**
 * This file is part of Curry package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
declare(strict_types=1);

namespace Serafim\Curry\Renderer;

use Serafim\Curry\Renderable;

/**
 * Class ArgumentsRenderer
 */
class ClosureRenderer implements Renderable
{
    use ValueToString;

    /**
     * @var \Closure
     */
    private $context;

    /**
     * @var array
     */
    private $left;

    /**
     * @var array
     */
    private $right;

    /**
     * @var \ReflectionFunction
     */
    private $reflection;

    /**
     * ArgumentsRenderer constructor.
     * @param \Closure $context
     * @param array $left
     * @param array $right
     * @throws \ReflectionException
     */
    public function __construct(\Closure $context, array $left, array $right)
    {
        $this->context = $context;
        $this->reflection = new \ReflectionFunction($context);
        $this->left = $left;
        $this->right = $right;
    }

    /**
     * @return int
     */
    private function getObjectId(): int
    {
        return (int)\spl_object_id($this->context);
    }

    /**
     * @return string|null
     */
    private function getThis(): ?string
    {
        $class = $this->reflection->getClosureScopeClass();

        return $class ? $this->objectToString($this->reflection->getClosureThis()) : null;
    }

    /**
     * @return string|null
     */
    private function getSelf(): ?string
    {
        $class = $this->reflection->getClosureScopeClass();

        return $class ? $class->getName() : null;
    }

    /**
     * @return string
     */
    public function getFile(): string
    {
        return $this->reflection->getFileName();
    }

    /**
     * @return string
     */
    public function getLine(): string
    {
        return $this->reflection->getStartLine() . ' to ' . $this->reflection->getEndLine();
    }

    /**
     * @return string
     */
    private function getLeftArguments(): string
    {
        return $this->getArguments(...$this->left);
    }

    /**
     * @return string
     */
    private function getRightArguments(): string
    {
        return $this->getArguments(...$this->right);
    }

    /**
     * @param \Closure $closure
     * @return string
     */
    public static function fallback(\Closure $closure): string
    {
        return 'curried ' . (string)\print_r($closure, true);
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        try {
            $id    = $this->getObjectId();
            $left  = $this->getLeftArguments() ?: '_';
            $right = $this->getRightArguments() ?: '_';
            $_this = $this->getThis();
            $_self = $this->getSelf();

            $result[] = \sprintf('Curried(%s ... %s) #%d => {', $left, $right, $id);

            if ($_self) {
                $result[] = \sprintf('    class: "%s"', $_self);
            }

            if ($_this) {
                $result[] = \sprintf('    this: %s', $_this);
            }

            if ($this->reflection->isInternal()) {
                $ext = $this->reflection->getExtension();

                $result[] = \sprintf('    extension: %s', $ext->getName());
                $result[] = \sprintf('    version: %s', $ext->getVersion());
            } else {
                $result[] = \sprintf('    file: "%s"', $this->getFile());
                $result[] = \sprintf('    line: "%s"', $this->getLine());
            }
            $result[] = '}';

            return \implode(\PHP_EOL, $result);
        } catch (\Throwable $e) {
            return self::fallback($this->context);
        }
    }
}
