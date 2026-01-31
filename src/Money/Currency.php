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

namespace Qubus\ValueObjects\Money;

use Money\Currency as BaseCurrency;
use Qubus\ValueObjects\Util;
use Qubus\ValueObjects\ValueObject;

class Currency implements ValueObject
{
    /** @var BaseCurrency $currency */
    protected BaseCurrency $currency;

    /** @var CurrencyCode $code */
    protected CurrencyCode $code;

    /**
     * Returns a new Currency object from native string currency code
     *
     * @param mixed ...$code Currency code
     * @return self
     */
    public static function fromNative(mixed ...$code): self
    {
        return new self(CurrencyCode::get($code[0]));
    }

    public function __construct(CurrencyCode $code)
    {
        $this->code     = $code;
        $this->currency = new BaseCurrency($code->toNative());
    }

    /**
     * Tells whether two Currency are equal by comparing their names
     */
    public function equals(ValueObject $currency): bool
    {
        if (false === Util::classEquals($this, $currency)) {
            return false;
        }

        return $this->toNative() === $currency->toNative();
    }

    /**
     * Returns currency code
     */
    public function getCode(): CurrencyCode
    {
        return $this->code;
    }

    /**
     * Returns string representation of the currency
     */
    public function __toString(): string
    {
        return $this->toNative();
    }

    /**
     * Returns string representation of the currency
     */
    public function toNative(): string
    {
        return $this->getCode()->toNative();
    }
}
