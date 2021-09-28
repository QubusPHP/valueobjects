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

use Qubus\ValueObjects\Geography\CountryCode;
use Qubus\ValueObjects\Geography\CountryCodeName;
use Qubus\ValueObjects\StringLiteral\StringLiteral;
use Qubus\ValueObjects\Util;
use Qubus\ValueObjects\ValueObject;

use function func_get_arg;

class Country implements ValueObject
{
    /** @var CountryCode $code */
    protected $code;

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
        return $this->getName()->toNative();
    }

    /**
     * Returns a new Country object given a native PHP string country code.
     *
     * @param ...string $code
     * @return Country|ValueObject
     */
    public static function fromNative(): ValueObject
    {
        $codeString = func_get_arg(0);
        $code = CountryCode::byName($codeString);
        return new static($code);
    }

    /**
     * Tells whether two Country are equal.
     *
     * @param Country|ValueObject $country
     */
    public function equals(ValueObject $country): bool
    {
        if (false === Util::classEquals($this, $country)) {
            return false;
        }

        return $this->getCode()->equals($country->getCode());
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
}
