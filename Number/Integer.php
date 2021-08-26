<?php

/**
 * Qubus\ValueObjects
 *
 * @link       https://github.com/QubusPHP/valueobjects
 *
 * @since      1.0.0
 */

declare(strict_types=1);

namespace Qubus\ValueObjects\Number;

use Qubus\Exception\Data\TypeException;
use Qubus\ValueObjects\Number\Real;
use Qubus\ValueObjects\Util;
use Qubus\ValueObjects\ValueObject;

use function filter_var;
use function intval;
use function sprintf;

use const FILTER_VALIDATE_INT;

class Integer extends Real
{
    /**
     * Returns a Integer object given a PHP native int as parameter.
     *
     * @param int $value
     */
    public function __construct($value)
    {
        $value = filter_var($value, FILTER_VALIDATE_INT);

        if (false === $value) {
            throw new TypeException(
                sprintf(
                    'Argument "%s" is invalid. Must be an integer.',
                    $value
                )
            );
        }

        parent::__construct($value);
    }

    /**
     * Tells whether two Integer are equal by comparing their values
     */
    public function equals(ValueObject $integer): bool
    {
        if (false === Util::classEquals($this, $integer)) {
            return false;
        }

        return $this->toNative() === $integer->toNative();
    }

    /**
     * Returns the value of the integer number
     */
    public function toNative(): int
    {
        return intval(parent::toNative());
    }

    /**
     * Returns a Real with the value of the Integer
     */
    public function toReal(): Real
    {
        return new Real($this->toNative());
    }
}
