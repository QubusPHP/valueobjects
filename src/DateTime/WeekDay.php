<?php

declare(strict_types=1);

namespace Qubus\ValueObjects\DateTime;

use Carbon\CarbonImmutable;
use Qubus\ValueObjects\Enum\Enum;

/**
 * Class WeekDay.
 */
class WeekDay extends Enum
{
    const MONDAY = 'Monday';
    const TUESDAY = 'Tuesday';
    const WEDNESDAY = 'Wednesday';
    const THURSDAY = 'Thursday';
    const FRIDAY = 'Friday';
    const SATURDAY = 'Saturday';
    const SUNDAY = 'Sunday';

    /**
     * Returns the current week day.
     *
     * @return WeekDay
     */
    public static function now(): WeekDay
    {
        return static::fromNativeCarbonImmutable(new CarbonImmutable('now'));
    }

    /**
     * Returns a WeekDay from a PHP native \DateTime.
     *
     * @param CarbonImmutable $date
     *
     * @return WeekDay
     */
    public static function fromNativeCarbonImmutable(CarbonImmutable $date): WeekDay
    {
        $weekDay = strtoupper($date->format('l'));

        return static::byName($weekDay);
    }

    /**
     * Returns a numeric representation of the WeekDay.
     * 1 for Monday to 7 for Sunday.
     *
     * @return int
     */
    public function getNumericValue(): int
    {
        return $this->getOrdinal() + 1;
    }
}
