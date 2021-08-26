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

namespace Qubus\ValueObjects\NullValue;

use BadMethodCallException;
use Qubus\ValueObjects\Util;
use Qubus\ValueObjects\ValueObject;

use function strval;

class NullValue implements ValueObject
{
    /**
     * @throws BadMethodCallException
     */
    public static function fromNative(): ValueObject
    {
        throw new BadMethodCallException('Cannot create a NullValue object via this method.');
    }

    /**
     * Returns a new Null object
     *
     * @return NullValue|ValueObject
     */
    public static function create(): ValueObject
    {
        return new static();
    }

    /**
     * Tells whether two objects are both Null.
     */
    public function equals(ValueObject $null): bool
    {
        return Util::classEquals($this, $null);
    }

    /**
     * Returns a string representation of the Null object
     */
    public function __toString(): string
    {
        return strval(null);
    }
}
