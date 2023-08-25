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
use Qubus\ValueObjects\Enum\Enum;

use function strtoupper;

class WeekDay extends Enum
{
    public const MONDAY = 'Monday';
    public const TUESDAY = 'Tuesday';
    public const WEDNESDAY = 'Wednesday';
    public const THURSDAY = 'Thursday';
    public const FRIDAY = 'Friday';
    public const SATURDAY = 'Saturday';
    public const SUNDAY = 'Sunday';

    /**
     * Returns the current week day.
     */
    public static function now(): WeekDay
    {
        return static::fromNativeCarbonImmutable(new CarbonImmutable('now'));
    }

    /**
     * Returns a WeekDay from a PHP native \DateTime.
     */
    public static function fromNativeCarbonImmutable(CarbonImmutable $date): WeekDay
    {
        $weekDay = strtoupper($date->format('l'));

        return static::byName($weekDay);
    }

    /**
     * Returns a numeric representation of the WeekDay.
     * 1 for Monday to 7 for Sunday.
     */
    public function getNumericValue(): int
    {
        return $this->getOrdinal() + 1;
    }
}
