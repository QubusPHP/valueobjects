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
use Qubus\ValueObjects\DateTime\Hour;
use Qubus\ValueObjects\DateTime\Minute;
use Qubus\ValueObjects\DateTime\Second;
use Qubus\ValueObjects\Util;
use Qubus\ValueObjects\ValueObject;

use function func_get_args;
use function intval;
use function sprintf;

class Time implements ValueObject
{
    protected Hour $hour;
    protected Minute $minute;
    protected Second $second;

    /**
     * Returns a new Time objects.
     */
    public function __construct(Hour $hour, Minute $minute, Second $second)
    {
        $this->hour = $hour;
        $this->minute = $minute;
        $this->second = $second;
    }

    /**
     * Returns time as string in format G:i:s.
     */
    public function __toString(): string
    {
        return $this->toNativeCarbonImmutable()->format('G:i:s');
    }

    /**
     * Returns a nee Time object from native int hour, minute and second.
     *
     * @param  int $hour
     * @param  int $minute
     * @param  int $second
     * @return Time|ValueObject
     */
    public static function fromNative(): ValueObject
    {
        $args = func_get_args();

        return new static(new Hour($args[0]), new Minute($args[1]), new Second($args[2]));
    }

    /**
     * Returns a new Time from a native CarbonImmutable.
     *
     * @return Time|ValueObject
     */
    public static function fromNativeCarbonImmutable(CarbonImmutable $time): ValueObject
    {
        $hour = intval($time->format('G'));
        $minute = intval($time->format('i'));
        $second = intval($time->format('s'));

        return static::fromNative($hour, $minute, $second);
    }

    /**
     * Returns current Time.
     *
     * @return Time|ValueObject
     */
    public static function now(): ValueObject
    {
        return new static(Hour::now(), Minute::now(), Second::now());
    }

    /**
     * Return zero time.
     *
     * @return Time|ValueObject
     */
    public static function zero(): ValueObject
    {
        return new static(new Hour(0), new Minute(0), new Second(0));
    }

    /**
     * Tells whether two Time are equal by comparing their values.
     *
     * @param Time|ValueObject $time
     */
    public function equals(ValueObject $time): bool
    {
        if (false === Util::classEquals($this, $time)) {
            return false;
        }

        return $this->getHour()->equals($time->getHour())
        && $this->getMinute()->equals($time->getMinute())
        && $this->getSecond()->equals($time->getSecond());
    }

    /**
     * Get hour.
     */
    public function getHour(): Hour
    {
        return $this->hour;
    }

    /**
     * Get minute.
     */
    public function getMinute(): Minute
    {
        return $this->minute;
    }

    /**
     * Get second.
     */
    public function getSecond(): Second
    {
        return $this->second;
    }

    /**
     * Returns a native CarbonImmutable version of the current Time.
     * Date is set to current.
     */
    public function toNativeCarbonImmutable(): CarbonImmutable
    {
        return new CarbonImmutable(
            sprintf(
                '%d:%d:%d',
                $this->getHour()->toNative(),
                $this->getMinute()->toNative(),
                $this->getSecond()->toNative()
            )
        );
    }
}
