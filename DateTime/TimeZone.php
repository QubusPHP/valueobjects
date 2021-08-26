<?php

/**
 * Qubus\ValueObjects
 *
 * @link       https://github.com/QubusPHP/valueobjects
 *
 * @since      1.0.0
 */

declare(strict_types=1);

namespace Qubus\ValueObjects\DateTime;

use Carbon\CarbonTimeZone;
use Qubus\ValueObjects\DateTime\Exception\InvalidTimeZoneException;
use Qubus\ValueObjects\StringLiteral\StringLiteral;
use Qubus\ValueObjects\Util;
use Qubus\ValueObjects\ValueObject;

use function date_default_timezone_get;
use function func_get_args;
use function in_array;
use function strval;
use function timezone_identifiers_list;

class TimeZone implements ValueObject
{
    protected StringLiteral $name;

    /**
     * Returns a new TimeZone object.
     *
     * @throws InvalidTimeZoneException
     */
    public function __construct(StringLiteral $name)
    {
        if (! in_array($name->toNative(), timezone_identifiers_list())) {
            throw new InvalidTimeZoneException($name);
        }

        $this->name = $name;
    }

    /**
     * Returns timezone name as string.
     */
    public function __toString(): string
    {
        return strval($this->getName());
    }

    /**
     * Returns a new Time object from native timezone name.
     *
     * @param  string $name
     * @throws InvalidTimeZoneException
     * @return TimeZone|ValueObject
     */
    public static function fromNative(): ValueObject
    {
        $args = func_get_args();

        $name = new StringLiteral($args[0]);

        return new static($name);
    }

    /**
     * Returns a new Time from a native PHP \DateTime.
     *
     * @throws InvalidTimeZoneException
     * @return TimeZone|ValueObject
     */
    public static function fromNativeCarbonTimeZone(CarbonTimeZone $timezone): ValueObject
    {
        return static::fromNative($timezone->getName());
    }

    /**
     * Returns default TimeZone.
     *
     * @throws InvalidTimeZoneException
     * @return TimeZone|ValueObject
     */
    public static function fromDefault()
    {
        return new static(new StringLiteral(date_default_timezone_get()));
    }

    /**
     * Returns a native CarbonTimeZone version of the current TimeZone.
     */
    public function toNativeCarbonTimeZone(): CarbonTimeZone
    {
        return new CarbonTimeZone($this->getName()->toNative());
    }

    /**
     * Tells whether two DateTimeZone are equal by comparing their names.
     *
     * @param  ValueObject|TimeZone $timezone
     */
    public function equals(ValueObject $timezone): bool
    {
        if (false === Util::classEquals($this, $timezone)) {
            return false;
        }

        return $this->getName()->equals($timezone->getName());
    }

    /**
     * Returns timezone name.
     */
    public function getName(): StringLiteral
    {
        return clone $this->name;
    }
}
