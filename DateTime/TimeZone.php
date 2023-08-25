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

use Carbon\CarbonTimeZone;
use Exception;
use Qubus\Exception\Data\TypeException;
use Qubus\ValueObjects\DateTime\Exception\InvalidTimeZoneException;
use Qubus\ValueObjects\StringLiteral\StringLiteral;
use Qubus\ValueObjects\Util;
use Qubus\ValueObjects\ValueObject;

use function date_default_timezone_get;
use function func_get_args;
use function in_array;
use function strval;
use function timezone_identifiers_list;

class TimeZone implements ValueObject
{
    protected StringLiteral $name;

    /**
     * Returns a new TimeZone object.
     *
     * @throws InvalidTimeZoneException
     */
    public function __construct(StringLiteral $name)
    {
        if (! in_array($name->toNative(), timezone_identifiers_list())) {
            throw new InvalidTimeZoneException($name);
        }

        $this->name = $name;
    }

    /**
     * Returns timezone name as string.
     */
    public function __toString(): string
    {
        return strval($this->getName());
    }

    /**
     * Returns a new Time object from native timezone name.
     *
     * @param  ...string $name
     * @return TimeZone|ValueObject
     * @throws InvalidTimeZoneException|TypeException
     */
    public static function fromNative(): TimeZone|ValueObject
    {
        $args = func_get_args();

        $name = new StringLiteral($args[0]);

        return new static($name);
    }

    /**
     * Returns a new Time from a native PHP \DateTime.
     *
     * @return TimeZone|ValueObject
     * @throws TypeException
     * @throws InvalidTimeZoneException
     */
    public static function fromNativeCarbonTimeZone(CarbonTimeZone $timezone): TimeZone|ValueObject
    {
        return static::fromNative($timezone->getName());
    }

    /**
     * Returns default TimeZone.
     *
     * @return TimeZone|ValueObject
     * @throws InvalidTimeZoneException|TypeException
     */
    public static function fromDefault(): TimeZone|ValueObject
    {
        return new static(new StringLiteral(date_default_timezone_get()));
    }

    /**
     * Returns a native CarbonTimeZone version of the current TimeZone.
     * @throws Exception
     */
    public function toNativeCarbonTimeZone(): CarbonTimeZone
    {
        return new CarbonTimeZone($this->getName()->toNative());
    }

    /**
     * Tells whether two DateTimeZone are equal by comparing their names.
     *
     * @param ValueObject|TimeZone $timezone
     * @return bool
     */
    public function equals(TimeZone|ValueObject $timezone): bool
    {
        if (false === Util::classEquals($this, $timezone)) {
            return false;
        }

        return $this->getName()->equals($timezone->getName());
    }

    /**
     * Returns timezone name.
     */
    public function getName(): StringLiteral
    {
        return clone $this->name;
    }
}
