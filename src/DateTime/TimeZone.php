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
use Qubus\ValueObjects\DateTime\Exception\InvalidTimeZoneException;
use Qubus\ValueObjects\StringLiteral\StringLiteral;
use Qubus\ValueObjects\Util;
use Qubus\ValueObjects\ValueObject;

use function date_default_timezone_get;
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
            throw new InvalidTimeZoneException($name->toNative());
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
     * @param  string ...$name
     * @return self
     * @throws InvalidTimeZoneException
     */
    public static function fromNative(string ...$name): self
    {
        $string = new StringLiteral($name[0]);

        return new self($string);
    }

    /**
     * Returns a new Time from a native PHP \DateTime.
     *
     * @param CarbonTimeZone $timezone
     * @return self
     * @throws InvalidTimeZoneException
     */
    public static function fromNativeCarbonTimeZone(CarbonTimeZone $timezone): self
    {
        return self::fromNative($timezone->getName());
    }

    /**
     * Returns default TimeZone.
     *
     * @return self
     * @throws InvalidTimeZoneException
     */
    public static function fromDefault(): self
    {
        return new self(new StringLiteral(date_default_timezone_get()));
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
     * @param ValueObject $timezone
     * @return bool
     * @throws Exception
     */
    public function equals(ValueObject $timezone): bool
    {
        if (false === Util::classEquals($this, $timezone)) {
            return false;
        }

        return $this->toNative() === $timezone->toNative();
    }

    /**
     * Returns timezone name.
     */
    public function getName(): StringLiteral
    {
        return clone $this->name;
    }

    /**
     * @throws Exception
     */
    public function toNative(): string
    {
        return $this->toNativeCarbonTimeZone()->getName();
    }
}
