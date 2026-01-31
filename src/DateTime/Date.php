<?php

/**
 * Qubus\ValueObjects
 *
 * @link       https://github.com/QubusPHP/valueobjects
 * @copyright  2020
 * @author     Joshua Parker <joshua@joshuaparker.dev>
 * @license    https://opensource.org/licenses/mit-license.php MIT License
 */

declare(strict_types=1);

namespace Qubus\ValueObjects\DateTime;

use Carbon\CarbonImmutable;
use DateMalformedStringException;
use Qubus\Exception\Data\TypeException;
use Qubus\ValueObjects\DateTime\Exception\InvalidDateException;
use Qubus\ValueObjects\Util;
use Qubus\ValueObjects\ValueObject;

use function intval;
use function sprintf;

class Date implements ValueObject
{
    public Year $year;
    public Month $month;
    public MonthDay $day;

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
            throw new InvalidDateException($year, $month, $day);
        }

        $this->year = $year;
        $this->month = $month;
        $this->day = $day;
    }

    /**
     * Returns date as string in format Y-n-j.
     *
     * @throws DateMalformedStringException
     */
    public function __toString(): string
    {
        return $this->toNative();
    }

    /**
     * Returns a new Date from native year, month and day values.
     *
     * @param string|int ...$args
     * @return Date
     * @throws TypeException
     * @throws InvalidDateException
     */
    public static function fromNative(...$args): Date
    {
        return new self(
            new Year($args[0]),
            Month::fromNative($args[1]),
            new MonthDay($args[2])
        );
    }

    /**
     * Returns a new Date from CarbonImmutable.
     *
     * @throws InvalidDateException|TypeException
     */
    public static function fromNativeCarbonImmutable(CarbonImmutable $date): self
    {
        $year = intval($date->format('Y'));
        $month = Month::fromNativeCarbonImmutable($date);
        $day = intval($date->format('d'));

        return new self(new Year($year), $month, new MonthDay($day));
    }

    /**
     * Returns current Date.
     *
     * @throws InvalidDateException
     * @throws TypeException
     */
    public static function now(): self
    {
        return new self(Year::now(), Month::now(), MonthDay::now());
    }

    /**
     * Tells whether two Dates are equal by comparing their values.
     *
     * @param ValueObject $date
     * @return bool
     * @throws DateMalformedStringException
     */
    public function equals(ValueObject $date): bool
    {
        if (false === Util::classEquals($this, $date)) {
            return false;
        }

        return $this->toNative() === $date->toNative();
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

    /**
     * Returns date as string in format Y-n-j.
     *
     * @throws DateMalformedStringException
     */
    public function toNative(): string
    {
        return $this->toNativeCarbonImmutable()->format(format: 'Y-n-j');
    }
}
