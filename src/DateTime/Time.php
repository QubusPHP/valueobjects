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
use Qubus\Exception\Data\TypeException;
use Qubus\ValueObjects\Util;
use Qubus\ValueObjects\ValueObject;

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
        return $this->toNative();
    }

    /**
     * Returns a new Time object from native int hour, minute and second.
     *
     * @param int ...$int
     * @return Time
     * @throws TypeException
     */
    public static function fromNative(int ...$int): Time
    {
        return new self(new Hour($int[0]), new Minute($int[1]), new Second($int[2]));
    }

    /**
     * Returns a new Time from a native CarbonImmutable.
     *
     * @param CarbonImmutable $time
     * @return Time
     * @throws TypeException
     */
    public static function fromNativeCarbonImmutable(CarbonImmutable $time): Time
    {
        $hour = intval($time->format('G'));
        $minute = intval($time->format('i'));
        $second = intval($time->format('s'));

        return self::fromNative($hour, $minute, $second);
    }

    /**
     * Returns current Time.
     *
     * @return Time
     * @throws TypeException
     */
    public static function now(): Time
    {
        return new self(Hour::now(), Minute::now(), Second::now());
    }

    /**
     * Return zero time.
     *
     * @return Time
     * @throws TypeException
     */
    public static function zero(): Time
    {
        return new self(new Hour(0), new Minute(0), new Second(0));
    }

    /**
     * Tells whether two Time are equal by comparing their values.
     *
     * @param ValueObject $time
     * @return bool
     */
    public function equals(ValueObject $time): bool
    {
        if (false === Util::classEquals($this, $time)) {
            return false;
        }

        return $this->toNative() === $time->toNative();
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

    /**
     * Returns time as string in format G:i:s.
     *
     * @return string
     */
    public function toNative(): string
    {
        return $this->toNativeCarbonImmutable()->format(format: 'G:i:s');
    }
}
