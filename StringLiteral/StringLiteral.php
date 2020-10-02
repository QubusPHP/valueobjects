<?php

declare(strict_types=1);

namespace Qubus\ValueObjects\StringLiteral;

use Qubus\ValueObjects\Util;
use Qubus\Exception\Data\TypeException;
use Qubus\ValueObjects\ValueObjectInterface;

class StringLiteral implements ValueObjectInterface
{
    protected $value;

    /**
     * Returns a String object given a PHP native string as parameter.
     *
     * @param  string $value
     * @return StringLiteral|ValueObjectInterface
     */
    public static function fromNative(): ValueObjectInterface
    {
        $value = func_get_arg(0);

        return new static($value);
    }

    /**
     * Returns a String object given a PHP native string as parameter.
     *
     * @param  string $value
     * @throws \Qubus\Exception\Data\TypeException
     */
    public function __construct(string $value)
    {
        if (false === is_string($value)) {
            throw new TypeException(
                sprintf(
                    'Argument "%s" is invalid. Must enter a string.',
                    $value
                )
            );
        }

        $this->value = $value;
    }

    /**
     * Returns the value of the string.
     *
     * @return string
     */
    public function toNative(): string
    {
        return $this->value;
    }

    /**
     * Tells whether two strings are equal by comparing their values
     *
     * @param  ValueObjectInterface $string
     * @return bool
     */
    public function equals(ValueObjectInterface $stringLiteral): bool
    {
        if (false === Util::classEquals($this, $stringLiteral)) {
            return false;
        }

        return $this->toNative() === $stringLiteral->toNative();
    }

    /**
     * Tells whether the String is empty
     *
     * @return bool
     */
    public function isEmpty(): bool
    {
        return 0 == strlen($this->toNative());
    }

    /**
     * Returns the string value itself
     *
     * @return string
     */
    public function __toString(): string
    {
        return $this->toNative();
    }
}
