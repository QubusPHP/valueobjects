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

use Carbon\CarbonImmutable;
use Qubus\ValueObjects\DateTime\Date;
use Qubus\ValueObjects\DateTime\Exception\InvalidDateException;
use Qubus\ValueObjects\DateTime\Time;
use Qubus\ValueObjects\Util;
use Qubus\ValueObjects\ValueObject;

use function func_get_args;
use function sprintf;

class DateTime implements ValueObject
{
    protected Date $date;

    protected Time $time;

    /**
     * Returns a new DateTime object.
     */
    public function __construct(Date $date, ?Time $time = null)
    {
        $this->date = $date;
        if (null === $time) {
            $time = Time::zero();
        }
        $this->time = $time;
    }

    /**
     * Returns DateTime as string in format "Y-n-j G:i:s".
     */
    public function __toString(): string
    {
        return sprintf('%s %s', $this->getDate(), $this->getTime());
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
     * @throws InvalidDateException
     * @return DateTime|ValueObject
     */
    public static function fromNative(): ValueObject
    {
        $args = func_get_args();

        $date = Date::fromNative($args[0], $args[1], $args[2]);
        $time = Time::fromNative($args[3], $args[4], $args[5]);

        return new static($date, $time);
    }

    /**
     * Returns a new DateTime from native CarbonImmutable.
     *
     * @throws InvalidDateException
     */
    public static function fromNativeCarbonImmutable(CarbonImmutable $dateTime): DateTime
    {
        $date = Date::fromNativeCarbonImmutable($dateTime);
        $time = Time::fromNativeCarbonImmutable($dateTime);

        return new static($date, $time);
    }

    /**
     * Returns current DateTime.
     *
     * @throws InvalidDateException
     */
    public static function now(): DateTime
    {
        return new static(Date::now(), Time::now());
    }

    /**
     * Tells whether two DateTime are equal by comparing their values.
     */
    public function equals(ValueObject $dateTime): bool
    {
        if (false === Util::classEquals($this, $dateTime)) {
            return false;
        }

        return $this->getDate()->equals($dateTime->getDate())
        && $this->getTime()->equals($dateTime->getTime());
    }

    /**
     * Returns date from current DateTime.
     */
    public function getDate(): Date
    {
        return clone $this->date;
    }

    /**
     * Returns time from current DateTime.
     */
    public function getTime(): Time
    {
        return clone $this->time;
    }

    /**
     * Returns a CarbonImmutable version of the current DateTime.
     */
    public function toNativeCarbonImmutable(): CarbonImmutable
    {
        return new CarbonImmutable(
            sprintf(
                '%d-%d-%d %d:%d:%d',
                $this->getDate()->getYear()->toNative(),
                $this->getDate()->getMonth()->getNumericValue(),
                $this->getDate()->getDay()->toNative(),
                $this->getTime()->getHour()->toNative(),
                $this->getTime()->getMinute()->toNative(),
                $this->getTime()->getSecond()->toNative()
            )
        );
    }
}
