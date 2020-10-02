<?php

declare(strict_types=1);

namespace Qubus\ValueObjects\DateTime;

use Carbon\CarbonImmutable;
use Qubus\ValueObjects\Util;
use Qubus\ValueObjects\DateTime\DateTime;
use Qubus\ValueObjects\DateTime\TimeZone;
use Qubus\ValueObjects\ValueObjectInterface;

/**
 * Class DateTimeWithTimeZone.
 */
class DateTimeWithTimeZone implements ValueObjectInterface
{
    /**
     * @var DateTime
     */
    protected DateTime $dateTime;

    /**
     * @var TimeZone
     */
    protected TimeZone $timeZone;

    /**
     * Returns a new DateTimeWithTimeZone object.
     *
     * @param DateTime      $datetime
     * @param TimeZone|null $timezone
     */
    public function __construct(DateTime $datetime, TimeZone $timezone = null)
    {
        $this->dateTime = $datetime;
        $this->timeZone = $timezone;
    }

    /**
     * Returns DateTime as string in format "Y-n-j G:i:s.u e".
     *
     * @return string
     */
    public function __toString(): string
    {
        return sprintf('%s %s', $this->getDateTime(), $this->getTimeZone());
    }

    /**
     * Returns a new DateTime object from native values.
     *
     * @param int    $year
     * @param string $month
     * @param int    $day
     * @param int    $hour
     * @param int    $minute
     * @param int    $second
     * @param string $timezone
     *
     * @throws Exceptions\InvalidDateException
     * @throws Exceptions\InvalidTimeZoneException
     *
     * @return DateTimeWithTimeZone|ValueObjectInterface
     */
    public static function fromNative(): ValueObjectInterface
    {
        $args = func_get_args();

        return new static(
            DateTime::fromNative($args[0], $args[1], $args[2], $args[3], $args[4], $args[5]),
            TimeZone::fromNative($args[6])
        );
    }

    /**
     * Returns a new DateTime from a native PHP \DateTime.
     *
     * @param CarbonImmutable $nativeDatetime
     *
     * @throws Exceptions\InvalidDateException
     * @throws Exceptions\InvalidTimeZoneException
     *
     * @return DateTimeWithTimeZone|ValueObjectInterface
     */
    public static function fromNativeCarbonImmutable(CarbonImmutable $nativeDatetime): ValueObjectInterface
    {
        return new static(
            DateTime::fromNativeCarbonImmutable($nativeDatetime),
            TimeZone::fromNativeCarbonTimeZone($nativeDatetime->getTimezone())
        );
    }

    /**
     * Returns a DateTimeWithTimeZone object using current DateTime and default TimeZone.
     *
     * @throws Exceptions\InvalidDateException
     * @throws Exceptions\InvalidTimeZoneException
     *
     * @return DateTimeWithTimeZone|ValueObjectInterface
     */
    public static function now()
    {
        return new static(DateTime::now(), TimeZone::fromDefault());
    }

    /**
     * Tells whether two DateTimeWithTimeZone are equal by comparing their values.
     *
     * @param DateTimeWithTimeZone|ValueObjectInterface $dateTimeWithTimeZone
     *
     * @return bool
     */
    public function equals(ValueObjectInterface $dateTimeWithTimeZone): bool
    {
        if (false === Util::classEquals($this, $dateTimeWithTimeZone)) {
            return false;
        }

        return $this->getDateTime()->equals($dateTimeWithTimeZone->getDateTime())
            && $this->getTimeZone()->equals($dateTimeWithTimeZone->getTimeZone());
    }

    /**
     * Tells whether two DateTimeWithTimeZone represents the same timestamp.
     *
     * @param DateTimeWithTimeZone|ValueObjectInterface $dateTimeWithTimeZone
     *
     * @return bool
     */
    public function sameTimestampAs(ValueObjectInterface $dateTimeWithTimeZone): bool
    {
        if (false === Util::classEquals($this, $dateTimeWithTimeZone)) {
            return false;
        }

        return $this->toNativeCarbonImmutable() == $dateTimeWithTimeZone->toNativeCarbonImmutable();
    }

    /**
     * Returns datetime from current DateTimeWithTimeZone.
     *
     * @return DateTime
     */
    public function getDateTime(): DateTime
    {
        return clone $this->dateTime;
    }

    /**
     * Returns timezone from current DateTimeWithTimeZone.
     *
     * @return TimeZone
     */
    public function getTimeZone(): TimeZone
    {
        return clone $this->timeZone;
    }

    /**
     * Returns a Carbon version of the current DateTimeWithTimeZone.
     *
     * @return CarbonImmutable
     */
    public function toNativeCarbonImmutable(): CarbonImmutable
    {
        $date = $this->getDateTime()->getDate();
        $time = $this->getDateTime()->getTime();

        return new CarbonImmutable(
            sprintf(
                '%d-%d-%d %d:%d:%d',
                $date->getYear()->toNative(),
                $date->getMonth()->getNumericValue(),
                $date->getDay()->toNative(),
                $time->getHour()->toNative(),
                $time->getMinute()->toNative(),
                $time->getSecond()->toNative()
            ),
            $this->getTimeZone()->toNativeCarbonTimeZone()
        );
    }
}
