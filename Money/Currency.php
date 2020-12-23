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

namespace Qubus\ValueObjects\Money;

use Money\Currency as BaseCurrency;
use Qubus\ValueObjects\Money\CurrencyCode;
use Qubus\ValueObjects\Util;
use Qubus\ValueObjects\ValueObject;

use function func_get_arg;

class Currency implements ValueObject
{
    /** @var BaseCurrency */
    protected $currency;

    protected CurrencyCode $code;

    /**
     * Returns a new Currency object from native string currency code
     *
     * @param  string $code Currency code
     * @return Currency|ValueObject
     */
    public static function fromNative(): ValueObject
    {
        return new static(CurrencyCode::get(func_get_arg(0)));
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

        return $this->getCode()->toNative() === $currency->getCode()->toNative();
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
        return $this->getCode()->toNative();
    }
}
