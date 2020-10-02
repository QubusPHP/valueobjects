<?php

declare(strict_types=1);

namespace Qubus\ValueObjects\DateTime;

use Carbon\CarbonImmutable;
use Qubus\ValueObjects\Util;
use Qubus\ValueObjects\DateTime\Hour;
use Qubus\ValueObjects\DateTime\Minute;
use Qubus\ValueObjects\DateTime\Second;
use Qubus\ValueObjects\ValueObjectInterface;

/**
 * Class Time.
 */
class Time implements ValueObjectInterface
{
    /**
     * @var Hour
     */
    protected Hour $hour;

    /**
     * @var Minute
     */
    protected Minute $minute;

    /**
     * @var Second
     */
    protected Second $second;

    /**
     * Returns a new Time objects.
     *
     * @param Hour   $hour
     * @param Minute $minute
     * @param Second $second
     */
    public function __construct(Hour $hour, Minute $minute, Second $second)
    {
        $this->hour = $hour;
        $this->minute = $minute;
        $this->second = $second;
    }

    /**
     * Returns time as string in format G:i:s.
     *
     * @return string
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
     * @return Time|ValueObjectInterface
     */
    public static function fromNative(): ValueObjectInterface
    {
        $args = func_get_args();

        return new static(new Hour($args[0]), new Minute($args[1]), new Second($args[2]));
    }

    /**
     * Returns a new Time from a native CarbonImmutable.
     *
     * @param CarbonImmutable $time
     *
     * @return Time|ValueObjectInterface
     */
    public static function fromNativeCarbonImmutable(CarbonImmutable $time): ValueObjectInterface
    {
        $hour = intval($time->format('G'));
        $minute = intval($time->format('i'));
        $second = intval($time->format('s'));

        return static::fromNative($hour, $minute, $second);
    }

    /**
     * Returns current Time.
     *
     * @return Time|ValueObjectInterface
     */
    public static function now(): ValueObjectInterface
    {
        return new static(Hour::now(), Minute::now(), Second::now());
    }

    /**
     * Return zero time.
     *
     * @return Time|ValueObjectInterface
     */
    public static function zero(): ValueObjectInterface
    {
        return new static(new Hour(0), new Minute(0), new Second(0));
    }

    /**
     * Tells whether two Time are equal by comparing their values.
     *
     * @param Time|ValueObjectInterface $time
     *
     * @return bool
     */
    public function equals(ValueObjectInterface $time): bool
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
     *
     * @return Hour
     */
    public function getHour(): Hour
    {
        return $this->hour;
    }

    /**
     * Get minute.
     *
     * @return Minute
     */
    public function getMinute(): Minute
    {
        return $this->minute;
    }

    /**
     * Get second.
     *
     * @return Second
     */
    public function getSecond(): Second
    {
        return $this->second;
    }

    /**
     * Returns a native CarbonImmutable version of the current Time.
     * Date is set to current.
     *
     * @return CarbonImmutable
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
