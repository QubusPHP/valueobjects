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

namespace Qubus\ValueObjects\DateTime;

use Carbon\CarbonImmutable;
use Qubus\ValueObjects\DateTime\Exception\InvalidDateException;
use Qubus\ValueObjects\DateTime\Month;
use Qubus\ValueObjects\DateTime\MonthDay;
use Qubus\ValueObjects\DateTime\Year;
use Qubus\ValueObjects\Util;
use Qubus\ValueObjects\ValueObject;

use function func_get_args;
use function intval;
use function sprintf;

class Date implements ValueObject
{
    protected Year $year;

    protected Month $month;

    protected MonthDay $day;

    /**
     * Create a new Date.
     *
     * @throws InvalidDateException
     */
    public function __construct(Year $year, Month $month, MonthDay $day)
    {
        CarbonImmutable::createFromFormat('Y-F-j', sprintf('%d-%s-%d', $year->toNative(), $month, $day->toNative()));
        $nativeDateErrors = CarbonImmutable::getLastErrors();

        if ($nativeDateErrors['warning_count'] > 0 || $nativeDateErrors['error_count'] > 0) {
            throw new InvalidDateException($year->toNative(), $month->toNative(), $day->toNative());
        }

        $this->year = $year;
        $this->month = $month;
        $this->day = $day;
    }

    /**
     * Returns date as string in format Y-n-j.
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
     * @throws InvalidDateException
     * @return Date|ValueObject
     */
    public static function fromNative(): ValueObject
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
     * @throws InvalidDateException
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
     * @throws InvalidDateException
     */
    public static function now(): Date
    {
        return new static(Year::now(), Month::now(), MonthDay::now());
    }

    /**
     * Tells whether two Date are equal by comparing their values.
     *
     * @param  ValueObject|Date $date
     */
    public function equals(ValueObject $date): bool
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
     */
    public function getYear(): Year
    {
        return clone $this->year;
    }

    /**
     * Get month.
     */
    public function getMonth(): Month
    {
        return $this->month;
    }

    /**
     * Get day.
     */
    public function getDay(): MonthDay
    {
        return clone $this->day;
    }

    /**
     * Returns a CarbonImmutable version of the current Date.
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
