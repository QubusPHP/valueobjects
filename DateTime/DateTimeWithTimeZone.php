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
use Exception;
use Qubus\Exception\Data\TypeException;
use Qubus\ValueObjects\DateTime\Exception\InvalidDateException;
use Qubus\ValueObjects\DateTime\Exception\InvalidTimeZoneException;
use Qubus\ValueObjects\Util;
use Qubus\ValueObjects\ValueObject;

use function func_get_args;
use function sprintf;

class DateTimeWithTimeZone implements ValueObject
{
    protected DateTime $dateTime;
    protected TimeZone $timeZone;

    /**
     * Returns a new DateTimeWithTimeZone object.
     */
    public function __construct(DateTime $datetime, ?TimeZone $timezone = null)
    {
        $this->dateTime = $datetime;
        $this->timeZone = $timezone;
    }

    /**
     * Returns DateTime as string in format "Y-n-j G:i:s.u e".
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
     * @return DateTimeWithTimeZone|ValueObject
     * @throws InvalidDateException|InvalidTimeZoneException|TypeException
     */
    public static function fromNative(): DateTimeWithTimeZone|ValueObject
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
     * @return DateTimeWithTimeZone|ValueObject
     * @throws InvalidDateException
     * @throws InvalidTimeZoneException
     * @throws TypeException
     */
    public static function fromNativeCarbonImmutable(CarbonImmutable $nativeDatetime): DateTimeWithTimeZone|ValueObject
    {
        return new static(
            DateTime::fromNativeCarbonImmutable($nativeDatetime),
            TimeZone::fromNativeCarbonTimeZone($nativeDatetime->getTimezone())
        );
    }

    /**
     * Returns a DateTimeWithTimeZone object using current DateTime and default TimeZone.
     *
     * @return DateTimeWithTimeZone|ValueObject
     * @throws InvalidTimeZoneException|TypeException
     * @throws InvalidDateException
     */
    public static function now(): DateTimeWithTimeZone|ValueObject
    {
        return new static(DateTime::now(), TimeZone::fromDefault());
    }

    /**
     * Tells whether two DateTimeWithTimeZone are equal by comparing their values.
     *
     * @param DateTimeWithTimeZone|ValueObject $dateTimeWithTimeZone
     * @return bool
     */
    public function equals(DateTimeWithTimeZone|ValueObject $dateTimeWithTimeZone): bool
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
     * @param DateTimeWithTimeZone|ValueObject $dateTimeWithTimeZone
     * @return bool
     * @throws Exception
     */
    public function sameTimestampAs(DateTimeWithTimeZone|ValueObject $dateTimeWithTimeZone): bool
    {
        if (false === Util::classEquals($this, $dateTimeWithTimeZone)) {
            return false;
        }

        return $this->toNativeCarbonImmutable() === $dateTimeWithTimeZone->toNativeCarbonImmutable();
    }

    /**
     * Returns datetime from current DateTimeWithTimeZone.
     */
    public function getDateTime(): DateTime
    {
        return clone $this->dateTime;
    }

    /**
     * Returns timezone from current DateTimeWithTimeZone.
     */
    public function getTimeZone(): TimeZone
    {
        return clone $this->timeZone;
    }

    /**
     * Returns a Carbon version of the current DateTimeWithTimeZone.
     * @throws Exception
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
