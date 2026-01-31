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

namespace Qubus\ValueObjects\Geography;

use Qubus\ValueObjects\StringLiteral\StringLiteral;
use Qubus\ValueObjects\Util;
use Qubus\ValueObjects\ValueObject;

class Country implements ValueObject
{
    /** @var CountryCode $code */
    protected CountryCode $code;

    /**
     * Returns a new Country object.
     */
    public function __construct(CountryCode $code)
    {
        $this->code = $code;
    }

    /**
     * Returns country name as native string.
     */
    public function __toString(): string
    {
        return $this->toNative();
    }

    /**
     * Returns a new Country object given a native PHP string country code.
     *
     * @param string ...$value
     * @return Country
     */
    public static function fromNative(string ...$value): Country
    {
        $code = CountryCode::byName($value[0]);
        return new self($code);
    }

    /**
     * Tells whether two Country are equal.
     *
     * @param ValueObject $country
     * @return bool
     */
    public function equals(ValueObject $country): bool
    {
        if (false === Util::classEquals($this, $country)) {
            return false;
        }

        return $this->toNative() === $country->toNative();
    }

    /**
     * Returns country code.
     */
    public function getCode(): CountryCode
    {
        return $this->code;
    }

    /**
     * Returns country name.
     */
    public function getName(): StringLiteral
    {
        return CountryCodeName::getName($this->getCode());
    }

    /**
     * Returns country name as native string.
     */
    public function toNative(): string
    {
        return $this->getName()->toNative();
    }
}
