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

namespace Qubus\ValueObjects\Number;

use Qubus\Exception\Data\TypeException;
use Qubus\ValueObjects\Number\IntegerNumber;
use Qubus\ValueObjects\Number\Natural;
use Qubus\ValueObjects\Number\RoundingMode;
use Qubus\ValueObjects\Util;
use Qubus\ValueObjects\ValueObject;

use function abs;
use function filter_var;
use function func_get_arg;
use function round;
use function sprintf;
use function strval;

use const FILTER_VALIDATE_FLOAT;

class RealNumber implements ValueObject
{
    /** @var float */
    protected $value;

    /**
     * Returns a RealNumber object given a PHP native float as parameter.
     *
     * @param  float $number
     * @return static
     */
    public static function fromNative(): ValueObject
    {
        $value = func_get_arg(0);

        return new static($value);
    }

    /**
     * Returns a RealNumber object given a PHP native float as parameter.
     *
     * @param float $number
     */
    public function __construct($value)
    {
        $stringValue = (string) $value;

        # In some locales the decimal-point character might be different,
        # which can cause filter_var($value, FILTER_VALIDATE_FLOAT) to fail.
        $stringValue = str_replace(',', '.', $stringValue);

        # Only apply the decimal-point character fix if needed, otherwise preserve the old value
        if ($stringValue !== (string) $value) {
            $value = filter_var($stringValue, FILTER_VALIDATE_FLOAT);
        } else {
            $value = filter_var($value, FILTER_VALIDATE_FLOAT);
        }

        if (false === $value) {
            throw new TypeException(
                sprintf(
                    'Argument "%s" is invalid. Must be a float.',
                    $value
                )
            );
        }

        $this->value = $value;
    }

    /**
     * Returns the native value of the real number
     *
     * @return float
     */
    public function toNative()
    {
        return $this->value;
    }

    /**
     * Tells whether two RealNumber's are equal by comparing their values.
     */
    public function equals(ValueObject $real): bool
    {
        if (false === Util::classEquals($this, $real)) {
            return false;
        }

        return $this->toNative() === $real->toNative();
    }

    /**
     * Returns the integer part of the RealNumber number as a IntegerNumber.
     *
     * @param  RoundingMode $roundingMode Rounding mode of the conversion.
     *                                     Defaults to RoundingMode::HALF_UP.
     */
    public function toInteger(?RoundingMode $roundingMode = null): IntegerNumber
    {
        if (null === $roundingMode) {
            $roundingMode = RoundingMode::HALF_UP();
        }

        $value        = $this->toNative();
        $integerValue = round($value, 0, $roundingMode->toNative());
        return new IntegerNumber($integerValue);
    }

    /**
     * Returns the absolute integer part of the RealNumber number as a Natural.
     *
     * @param  RoundingMode $roundingMode Rounding mode of the conversion.
     *                                     Defaults to RoundingMode::HALF_UP.
     */
    public function toNatural(?RoundingMode $roundingMode = null): Natural
    {
        $integerValue = $this->toInteger($roundingMode)->toNative();
        $naturalValue = abs($integerValue);
        return new Natural($naturalValue);
    }

    /**
     * Returns the string representation of the real value
     */
    public function __toString(): string
    {
        return strval($this->toNative());
    }
}
