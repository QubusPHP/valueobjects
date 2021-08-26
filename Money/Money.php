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
use Money\Money as BaseMoney;
use Qubus\ValueObjects\Money\Currency;
use Qubus\ValueObjects\Number\Integer;
use Qubus\ValueObjects\Number\Real;
use Qubus\ValueObjects\Number\RoundingMode;
use Qubus\ValueObjects\Util;
use Qubus\ValueObjects\ValueObject;

use function func_get_args;
use function round;
use function sprintf;

class Money implements ValueObject
{
    /** @var BaseMoney */
    protected $money;

    protected Currency $currency;

    /**
     * Returns a Money object from native int amount and string currency code
     *
     * @param  int    $amount   Amount expressed in the smallest units of $currency (e.g. cents)
     * @param  string $currency Currency code of the money object
     * @return static
     */
    public static function fromNative(): ValueObject
    {
        $args = func_get_args();

        $amount   = new Integer($args[0]);
        $currency = Currency::fromNative($args[1]);

        return new static($amount, $currency);
    }

    /**
     * Returns a Money object
     *
     * @param Integer  $amount   Amount expressed in the smallest units of $currency (e.g. cents)
     * @param Currency $currency Currency of the money object
     */
    public function __construct(Integer $amount, Currency $currency)
    {
        $baseCurrency   = new BaseCurrency($currency->getCode()->toNative());
        $this->money    = new BaseMoney($amount->toNative(), $baseCurrency);
        $this->currency = $currency;
    }

    /**
     *  Tells whether two Currency are equal by comparing their amount and currency
     */
    public function equals(ValueObject $money): bool
    {
        if (false === Util::classEquals($this, $money)) {
            return false;
        }

        return $this->getAmount()->equals($money->getAmount()) && $this->getCurrency()->equals($money->getCurrency());
    }

    /**
     * Returns money amount
     */
    public function getAmount(): Integer
    {
        return new Integer($this->money->getAmount());
    }

    /**
     * Returns money currency
     */
    public function getCurrency(): Currency
    {
        return clone $this->currency;
    }

    /**
     * Add an integer quantity to the amount and returns a new Money object.
     * Use a negative quantity for subtraction.
     *
     * @param  Integer $quantity Quantity to add
     */
    public function add(Integer $quantity): Money
    {
        $amount = new Integer($this->getAmount()->toNative() + $quantity->toNative());
        return new static($amount, $this->getCurrency());
    }

    /**
     * Multiply the Money amount for a given number and returns a new Money object.
     * Use 0 < Real $multipler < 1 for division.
     *
     * @param  mixed $roundingMode Rounding mode of the operation. Defaults to RoundingMode::HALF_UP.
     */
    public function multiply(Real $multiplier, ?RoundingMode $roundingMode = null): Money
    {
        if (null === $roundingMode) {
            $roundingMode = RoundingMode::HALF_UP();
        }

        $amount        = $this->getAmount()->toNative() * $multiplier->toNative();
        $roundedAmount = new Integer(round($amount, 0, $roundingMode->toNative()));
        return new static($roundedAmount, $this->getCurrency());
    }

    /**
     * Returns a string representation of the Money value in format "CUR AMOUNT" (e.g.: EUR 1000)
     */
    public function __toString(): string
    {
        return sprintf('%s %d', $this->getCurrency()->getCode(), $this->getAmount()->toNative());
    }
}
