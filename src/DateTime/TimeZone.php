<?php

declare(strict_types=1);

namespace Qubus\ValueObjects\DateTime;

use Carbon\CarbonTimeZone;
use Qubus\ValueObjects\Util;
use Qubus\ValueObjects\DateTime\Year;
use Qubus\ValueObjects\DateTime\Month;
use Qubus\ValueObjects\DateTime\MonthDay;
use Qubus\ValueObjects\ValueObjectInterface;
use Qubus\ValueObjects\StringLiteral\StringLiteral;

/**
 * Class TimeZone.
 */
class TimeZone implements ValueObjectInterface
{
    /**
     * @var StringLiteral
     */
    protected StringLiteral $name;

    /**
     * Returns a new TimeZone object.
     *
     * @param  StringLiteral $name
     * @throws Exceptions\InvalidTimeZoneException
     */
    public function __construct(StringLiteral $name)
    {
        if (!in_array($name->toNative(), timezone_identifiers_list())) {
            throw new Exceptions\InvalidTimeZoneException($name);
        }

        $this->name = $name;
    }

    /**
     * Returns timezone name as string.
     *
     * @return string
     */
    public function __toString(): string
    {
        return strval($this->getName());
    }

    /**
     * Returns a new Time object from native timezone name.
     *
     * @param  string $name
     * @throws Exceptions\InvalidTimeZoneException
     * @return TimeZone|ValueObjectInterface
     */
    public static function fromNative(): ValueObjectInterface
    {
        $args = func_get_args();

        $name = new StringLiteral($args[0]);

        return new static($name);
    }

    /**
     * Returns a new Time from a native PHP \DateTime.
     *
     * @param  CarbonTimeZone $timezone
     * @throws Exceptions\InvalidTimeZoneException
     * @return TimeZone|ValueObjectInterface
     */
    public static function fromNativeCarbonTimeZone(CarbonTimeZone $timezone): ValueObjectInterface
    {
        return static::fromNative($timezone->getName());
    }

    /**
     * Returns default TimeZone.
     *
     * @throws Exceptions\InvalidTimeZoneException
     * @return TimeZone|ValueObjectInterface
     */
    public static function fromDefault()
    {
        return new static(new StringLiteral(date_default_timezone_get()));
    }

    /**
     * Returns a native CarbonTimeZone version of the current TimeZone.
     *
     * @return CarbonTimeZone
     */
    public function toNativeCarbonTimeZone(): CarbonTimeZone
    {
        return new CarbonTimeZone($this->getName()->toNative());
    }

    /**
     * Tells whether two DateTimeZone are equal by comparing their names.
     *
     * @param  ValueObjectInterface|TimeZone $timezone
     * @return bool
     */
    public function equals(ValueObjectInterface $timezone): bool
    {
        if (false === Util::classEquals($this, $timezone)) {
            return false;
        }

        return $this->getName()->equals($timezone->getName());
    }

    /**
     * Returns timezone name.
     *
     * @return StringLiteral
     */
    public function getName(): StringLiteral
    {
        return clone $this->name;
    }
}
