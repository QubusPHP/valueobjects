<?php

declare(strict_types=1);

namespace Qubus\ValueObjects\Geography;

use Qubus\ValueObjects\Util;
use Qubus\ValueObjects\ValueObjectInterface;
use Qubus\ValueObjects\Geography\CountryCode;
use Qubus\ValueObjects\Geography\CountryCodeName;
use Qubus\ValueObjects\StringLiteral\StringLiteral;

class Country implements ValueObjectInterface
{
    /**
     * @var CountryCode
     */
    protected CountryCode $code;

    /**
     * Returns a new Country object.
     *
     * @param CountryCode $code
     */
    public function __construct(CountryCode $code)
    {
        $this->code = $code;
    }

    /**
     * Returns country name as native string.
     *
     * @return string
     */
    public function __toString(): string
    {
        return $this->getName()->toNative();
    }

    /**
     * Returns a new Country object given a native PHP string country code.
     *
     * @param ...string $code
     *
     * @return Country|ValueObjectInterface
     */
    public static function fromNative(): ValueObjectInterface
    {
        $codeString = func_get_arg(0);
        $code = CountryCode::byName($codeString);
        $country = new static($code);

        return $country;
    }

    /**
     * Tells whether two Country are equal.
     *
     * @param Country|ValueObjectInterface $country
     *
     * @return bool
     */
    public function equals(ValueObjectInterface $country): bool
    {
        if (false === Util::classEquals($this, $country)) {
            return false;
        }

        return $this->getCode()->equals($country->getCode());
    }

    /**
     * Returns country code.
     *
     * @return CountryCode
     */
    public function getCode(): CountryCode
    {
        return $this->code;
    }

    /**
     * Returns country name.
     *
     * @return StringLiteral
     */
    public function getName(): StringLiteral
    {
        return CountryCodeName::getName($this->getCode());
    }
}
