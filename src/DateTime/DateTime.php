<?php

declare(strict_types=1);

namespace Qubus\ValueObjects\DateTime;

use Carbon\CarbonImmutable;
use Qubus\ValueObjects\Util;
use Qubus\ValueObjects\DateTime\Date;
use Qubus\ValueObjects\DateTime\Time;
use Qubus\ValueObjects\DateTime\Year;
use Qubus\ValueObjects\DateTime\Month;
use Qubus\ValueObjects\DateTime\MonthDay;
use Qubus\ValueObjects\ValueObjectInterface;

class DateTime implements ValueObjectInterface
{
    /**
     * @var Date
     */
    protected Date $date;

    /**
     * @var Time
     */
    protected Time $time;

    /**
     * Returns a new DateTime object.
     *
     * @param Date $date
     * @param Time $time
     */
    public function __construct(Date $date, Time $time = null)
    {
        $this->date = $date;
        if (null === $time) {
            $time = Time::zero();
        }
        $this->time = $time;
    }

    /**
     * Returns DateTime as string in format "Y-n-j G:i:s".
     *
     * @return string
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
     *
     * @throws Exceptions\InvalidDateException
     *
     * @return DateTime|ValueObjectInterface
     */
    public static function fromNative(): ValueObjectInterface
    {
        $args = func_get_args();

        $date = Date::fromNative($args[0], $args[1], $args[2]);
        $time = Time::fromNative($args[3], $args[4], $args[5]);

        return new static($date, $time);
    }

    /**
     * Returns a new DateTime from native CarbonImmutable.
     *
     * @param  CarbonImmutable $date_time
     * @throws Exceptions\InvalidDateException
     * @return DateTime
     */
    public static function fromNativeCarbonImmutable(CarbonImmutable $date_time): DateTime
    {
        $date = Date::fromNativeCarbonImmutable($date_time);
        $time = Time::fromNativeCarbonImmutable($date_time);

        return new static($date, $time);
    }

    /**
     * Returns current DateTime.
     *
     * @throws Exceptions\InvalidDateException
     *
     * @return DateTime
     */
    public static function now(): DateTime
    {
        $dateTime = new static(Date::now(), Time::now());

        return $dateTime;
    }

    /**
     * Tells whether two DateTime are equal by comparing their values.
     *
     * @param ValueObjectInterface $date_time
     *
     * @return bool
     */
    public function equals(ValueObjectInterface $date_time): bool
    {
        if (false === Util::classEquals($this, $date_time)) {
            return false;
        }

        return $this->getDate()->equals($date_time->getDate())
            && $this->getTime()->equals($date_time->getTime());
    }

    /**
     * Returns date from current DateTime.
     *
     * @return Date
     */
    public function getDate(): Date
    {
        return clone $this->date;
    }

    /**
     * Returns time from current DateTime.
     *
     * @return Time
     */
    public function getTime(): Time
    {
        return clone $this->time;
    }

    /**
     * Returns a CarbonImmutable version of the current DateTime.
     *
     * @return CarbonImmutable
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
