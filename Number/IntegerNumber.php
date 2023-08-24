<?php

/**
 * Qubus\ValueObjects
 *
 * @link       https://github.com/QubusPHP/valueobjects
 * @copyright  2020
 * @author     Joshua Parker <joshua@joshuaparker.dev>
 * @license    https://opensource.org/licenses/mit-license.php MIT License
 *
 * @since      1.0.0
 */

declare(strict_types=1);

namespace Qubus\ValueObjects\Number;

use Qubus\Exception\Data\TypeException;
use Qubus\ValueObjects\Util;
use Qubus\ValueObjects\ValueObject;

use function filter_var;
use function intval;
use function sprintf;

use const FILTER_VALIDATE_INT;

class IntegerNumber extends RealNumber
{
    /**
     * Returns a IntegerNumber object given a PHP native int as parameter.
     *
     * @param int $value
     * @throws TypeException
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
     * Tells whether two IntegerNumber are equal by comparing their values
     */
    public function equals(IntegerNumber|ValueObject $integer): bool
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
     * Returns a RealNumber with the value of the IntegerNumber
     * @throws TypeException
     */
    public function toRealNumber(): RealNumber
    {
        return new RealNumber($this->toNative());
    }
}
