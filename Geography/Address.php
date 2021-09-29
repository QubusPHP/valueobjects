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

namespace Qubus\ValueObjects\Geography;

use BadMethodCallException;
use Qubus\ValueObjects\Geography\Country;
use Qubus\ValueObjects\Geography\Street;
use Qubus\ValueObjects\StringLiteral\StringLiteral;
use Qubus\ValueObjects\Util;
use Qubus\ValueObjects\ValueObject;

use function count;
use function func_get_args;
use function sprintf;

class Address implements ValueObject
{
    /** @var StringLiteral */
    protected $name;
    /** @var Street */
    protected $street;
    /** @var StringLiteral */
    protected $district;
    /** @var StringLiteral */
    protected $city;
    /** @var StringLiteral */
    protected $region;
    /** @var StringLiteral */
    protected $postalCode;
    /** @var Country */
    protected $country;
    /**
     * Returns a new Address object.
     */
    public function __construct(
        $name,
        $street,
        $district,
        $city,
        $region,
        $postalCode,
        $country
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
     * @throws BadMethodCallException
     * @return Address|ValueObject
     */
    public static function fromNative(): ValueObject
    {
        $args = func_get_args();

        if (8 !== count($args)) {
            throw new BadMethodCallException(
                'You must provide exactly 8 arguments: 1) addressee name, 2) street name, 
                3) street number, 4) district, 5) city, 6) region, 7) postal code, 8) country code.'
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
     * @param Address|ValueObject $address
     */
    public function equals(ValueObject $address): bool
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
     */
    public function getName(): StringLiteral
    {
        return clone $this->name;
    }

    /**
     * Returns street.
     */
    public function getStreet(): Street
    {
        return clone $this->street;
    }

    /**
     * Returns district.
     */
    public function getDistrict(): StringLiteral
    {
        return clone $this->district;
    }

    /**
     * Returns city.
     */
    public function getCity(): StringLiteral
    {
        return clone $this->city;
    }

    /**
     * Returns region.
     */
    public function getRegion(): StringLiteral
    {
        return clone $this->region;
    }

    /**
     * Returns postal code.
     */
    public function getPostalCode(): StringLiteral
    {
        return clone $this->postalCode;
    }

    /**
     * Returns country.
     */
    public function getCountry(): Country
    {
        return clone $this->country;
    }
}
