<?php

/**
 * Qubus\ValueObjects
 *
 * @link       https://github.com/QubusPHP/valueobjects
 * @copyright  2020 Joshua Parker
 * @license    https://opensource.org/licenses/mit-license.php MIT License
 *
 * @since      1.0.0
 */

declare(strict_types=1);

namespace Qubus\ValueObjects\StringLiteral;

use Qubus\Exception\Data\TypeException;
use Qubus\ValueObjects\Util;
use Qubus\ValueObjects\ValueObject;

use function func_get_arg;
use function is_string;
use function sprintf;
use function strlen;

class StringLiteral implements ValueObject
{
    /**
     * Returns a String object given a PHP native string as parameter.
     *
     * @param  string $value
     * @return StringLiteral|ValueObject
     */
    public static function fromNative(): ValueObject
    {
        $value = func_get_arg(0);

        return new static($value);
    }

    /**
     * Returns a String object given a PHP native string as parameter.
     *
     * @throws TypeException
     */
    public function __construct(protected string $value)
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
     */
    public function toNative(): string
    {
        return $this->value;
    }

    /**
     * Tells whether two strings are equal by comparing their values
     *
     * @param  ValueObject $string
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
