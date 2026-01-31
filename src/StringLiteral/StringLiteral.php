<?php

/**
 * Qubus\ValueObjects
 *
 * @link       https://github.com/QubusPHP/valueobjects
 * @copyright  2020
 * @author     Joshua Parker <joshua@joshuaparker.dev>
 * @license    https://opensource.org/licenses/mit-license.php MIT License
 */

declare(strict_types=1);

namespace Qubus\ValueObjects\StringLiteral;

use Qubus\ValueObjects\Util;
use Qubus\ValueObjects\ValueObject;

use function strlen;

/** @phpstan-consistent-constructor */
class StringLiteral implements ValueObject
{
    /**
     * Returns a String object given a PHP native string as parameter.
     *
     * @param string ...$value
     * @return static
     */
    public static function fromNative(string ...$value): static
    {
        return new static($value[0]);
    }

    /**
     * Returns a String object given a PHP native string as parameter.
     */
    public function __construct(protected string $value)
    {
    }

    /**
     * Returns the value of the string.
     */
    public function toNative(): string
    {
        return $this->value;
    }

    /**
     * Tells whether two strings are equal by comparing their values
     *
     * @param ValueObject $stringLiteral
     * @return bool
     */
    public function equals(ValueObject $stringLiteral): bool
    {
        if (false === Util::classEquals($this, $stringLiteral)) {
            return false;
        }

        return $this->toNative() === $stringLiteral->toNative();
    }

    /**
     * Tells whether the String is empty
     */
    public function isEmpty(): bool
    {
        return 0 === strlen($this->toNative());
    }

    /**
     * Returns the string value itself
     */
    public function __toString(): string
    {
        return $this->toNative();
    }
}
