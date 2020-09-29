<?php

declare(strict_types=1);

namespace Qubus\ValueObjects\DateTime;

use Carbon\CarbonImmutable;
use Qubus\ValueObjects\Util;
use Qubus\ValueObjects\DateTime\Year;
use Qubus\ValueObjects\DateTime\Month;
use Qubus\ValueObjects\DateTime\MonthDay;
use Qubus\ValueObjects\ValueObjectInterface;

/**
 * Class Date.
 */
class Date implements ValueObjectInterface
{
    /**
     * @var Year
     */
    protected Year $year;

    /**
     * @var Month
     */
    protected Month $month;

    /**
     * @var MonthDay
     */
    protected MonthDay $day;

    /**
     * Create a new Date.
     *
     * @param  Year     $year
     * @param  Month    $month
     * @param  MonthDay $day
     * @throws Exceptions\InvalidDateException
     */
    public function __construct(Year $year, Month $month, MonthDay $day)
    {
        CarbonImmutable::createFromFormat('Y-F-j', sprintf('%d-%s-%d', $year->toNative(), $month, $day->toNative()));
        $nativeDateErrors = CarbonImmutable::getLastErrors();

        if ($nativeDateErrors['warning_count'] > 0 || $nativeDateErrors['error_count'] > 0) {
            throw new Exceptions\InvalidDateException($year->toNative(), $month->toNative(), $day->toNative());
        }

        $this->year = $year;
        $this->month = $month;
        $this->day = $day;
    }

    /**
     * Returns date as string in format Y-n-j.
     *
     * @return string
     */
    public function __toString(): string
    {
        return $this->toNativeCarbonImmutable()->format('Y-n-j');
    }

    /**
     * Returns a new Date from native year, month and day values.
     *
     * @param  int    $year
     * @param  string $month
     * @param  int    $day
     * @throws Exceptions\InvalidDateException
     * @return Date|ValueObjectInterface
     */
    public static function fromNative(): ValueObjectInterface
    {
        $args = func_get_args();

        return new static(
            new Year($args[0]),
            Month::fromNative($args[1]),
            new MonthDay($args[2])
        );
    }

    /**
     * Returns a new Date from CarbonImmutable.
     *
     * @param  CarbonImmutable $date
     * @throws Exceptions\InvalidDateException
     * @return Date
     */
    public static function fromNativeCarbonImmutable(CarbonImmutable $date): Date
    {
        $year = intval($date->format('Y'));
        $month = Month::fromNativeCarbonImmutable($date);
        $day = intval($date->format('d'));

        return new static(new Year($year), $month, new MonthDay($day));
    }

    /**
     * Returns current Date.
     *
     * @throws Exceptions\InvalidDateException
     * @return Date
     */
    public static function now(): Date
    {
        return new static(Year::now(), Month::now(), MonthDay::now());
    }

    /**
     * Tells whether two Date are equal by comparing their values.
     *
     * @param  ValueObjectInterface|Date $date
     * @return bool
     */
    public function equals(ValueObjectInterface $date): bool
    {
        if (false === Util::classEquals($this, $date)) {
            return false;
        }

        return $this->getYear()->equals($date->getYear()) &&
            $this->getMonth()->equals($date->getMonth()) &&
            $this->getDay()->equals($date->getDay());
    }

    /**
     * Get year.
     *
     * @return Year
     */
    public function getYear(): Year
    {
        return clone $this->year;
    }

    /**
     * Get month.
     *
     * @return Month
     */
    public function getMonth(): Month
    {
        return $this->month;
    }

    /**
     * Get day.
     *
     * @return MonthDay
     */
    public function getDay(): MonthDay
    {
        return clone $this->day;
    }

    /**
     * Returns a CarbonImmutable version of the current Date.
     *
     * @return CarbonImmutable
     */
    public function toNativeCarbonImmutable(): CarbonImmutable
    {
        return new CarbonImmutable(
            sprintf(
                '%d-%d-%d',
                $this->getYear()->toNative(),
                $this->getMonth()->getNumericValue(),
                $this->getDay()->toNative()
            )
        );
    }
}
