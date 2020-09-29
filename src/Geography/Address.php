<?php

declare(strict_types=1);

namespace Qubus\ValueObjects\Geography;

use Qubus\ValueObjects\Util;
use Qubus\ValueObjects\Geography\Street;
use Qubus\ValueObjects\Geography\Country;
use Qubus\ValueObjects\ValueObjectInterface;
use Qubus\ValueObjects\StringLiteral\StringLiteral;

class Address implements ValueObjectInterface
{
    /**
     * Name of the addressee (natural person or company).
     *
     * @var StringLiteral
     */
    protected StringLiteral $name;

    /**
     * @var Street
     */
    protected Street $street;

    /**
     * District/City area.
     *
     * @var StringLiteral
     */
    protected StringLiteral $district;

    /**
     * City/Town/Village.
     *
     * @var StringLiteral
     */
    protected StringLiteral $city;

    /**
     * Region/County/State.
     *
     * @var StringLiteral
     */
    protected StringLiteral $region;

    /**
     * Postal code/P.O. Box/ZIP code.
     *
     * @var StringLiteral
     */
    protected StringLiteral $postalCode;

    /**
     * @var Country
     */
    protected Country $country;

    /**
     * Returns a new Address object.
     *
     * @param StringLiteral $name
     * @param Street        $street
     * @param StringLiteral $district
     * @param StringLiteral $city
     * @param StringLiteral $region
     * @param StringLiteral $postalCode
     * @param Country       $country
     */
    public function __construct(
        StringLiteral $name,
        Street $street,
        StringLiteral $district,
        StringLiteral $city,
        StringLiteral $region,
        StringLiteral $postalCode,
        Country $country
    ) {
        $this->name = $name;
        $this->street = $street;
        $this->district = $district;
        $this->city = $city;
        $this->region = $region;
        $this->postalCode = $postalCode;
        $this->country = $country;
    }

    /**
     * Returns a string representation of the Address in US standard format.
     *
     * @return string
     */
    public function __toString(): string
    {
        $format = <<<'ADDR'
%s
%s
%s %s %s
%s
ADDR;

        return sprintf(
            $format,
            $this->getName(),
            $this->getStreet(),
            $this->getCity(),
            $this->getRegion(),
            $this->getPostalCode(),
            $this->getCountry()
        );
    }

    /**
     * Returns a new Address from native PHP arguments.
     *
     * @param string $name
     * @param string $street_name
     * @param string $street_number
     * @param string $district
     * @param string $city
     * @param string $region
     * @param string $postal_code
     * @param string $country_code
     *
     * @throws \BadMethodCallException
     *
     * @return Address|ValueObjectInterface
     */
    public static function fromNative(): ValueObjectInterface
    {
        $args = func_get_args();

        if (8 != count($args)) {
            throw new \BadMethodCallException(
                'You must provide exactly 8 arguments: 1) addressee name, 2) street name, 3) street number, 4) district, 5) city, 6) region, 7) postal code, 8) country code.'
            );
        }

        $name = new StringLiteral($args[0]);
        $street = new Street(new StringLiteral($args[1]), new StringLiteral($args[2]));
        $district = new StringLiteral($args[3]);
        $city = new StringLiteral($args[4]);
        $region = new StringLiteral($args[5]);
        $postalCode = new StringLiteral($args[6]);
        $country = Country::fromNative($args[7]);

        return new static($name, $street, $district, $city, $region, $postalCode, $country);
    }

    /**
     * Tells whether two Address are equal.
     *
     * @param Address|ValueObjectInterface $address
     *
     * @return bool
     */
    public function equals(ValueObjectInterface $address): bool
    {
        if (false === Util::classEquals($this, $address)) {
            return false;
        }

        return $this->getName()->equals($address->getName()) &&
            $this->getStreet()->equals($address->getStreet()) &&
            $this->getDistrict()->equals($address->getDistrict()) &&
            $this->getCity()->equals($address->getCity()) &&
            $this->getRegion()->equals($address->getRegion()) &&
            $this->getPostalCode()->equals($address->getPostalCode()) &&
            $this->getCountry()->equals($address->getCountry());
    }

    /**
     * Returns addressee name.
     *
     * @return StringLiteral
     */
    public function getName(): StringLiteral
    {
        return clone $this->name;
    }

    /**
     * Returns street.
     *
     * @return Street
     */
    public function getStreet(): Street
    {
        return clone $this->street;
    }

    /**
     * Returns district.
     *
     * @return StringLiteral
     */
    public function getDistrict(): StringLiteral
    {
        return clone $this->district;
    }

    /**
     * Returns city.
     *
     * @return StringLiteral
     */
    public function getCity(): StringLiteral
    {
        return clone $this->city;
    }

    /**
     * Returns region.
     *
     * @return StringLiteral
     */
    public function getRegion(): StringLiteral
    {
        return clone $this->region;
    }

    /**
     * Returns postal code.
     *
     * @return StringLiteral
     */
    public function getPostalCode(): StringLiteral
    {
        return clone $this->postalCode;
    }

    /**
     * Returns country.
     *
     * @return Country
     */
    public function getCountry(): Country
    {
        return clone $this->country;
    }
}
