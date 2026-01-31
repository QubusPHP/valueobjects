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

use BadMethodCallException;
use Money\Currency as BaseCurrency;
use Money\Money as BaseMoney;
use Qubus\Exception\Data\TypeException;
use Qubus\ValueObjects\Number\IntegerNumber;
use Qubus\ValueObjects\Number\RealNumber;
use Qubus\ValueObjects\Number\RoundingMode;
use Qubus\ValueObjects\Util;
use Qubus\ValueObjects\ValueObject;

use function round;
use function sprintf;

class Money implements ValueObject
{
    /** @var BaseMoney $money */
    protected BaseMoney $money;

    /** @var Currency $currency */
    protected Currency $currency;

    /**
     * Returns a Money object from native int amount and string currency code
     *
     * @param string|int ...$args
     * @return Money|ValueObject
     * @throws TypeException
     */
    public static function fromNative(...$args): Money|ValueObject
    {
        if (2 !== count($args)) {
            throw new BadMethodCallException(
                'You must provide exactly 2 arguments: 1) integer, 2) currency code string'
            );
        }
        $amount   = new IntegerNumber($args[0]);
        $currency = Currency::fromNative($args[1]);

        return new self($amount, $currency);
    }

    /**
     * Returns a Money object
     *
     * @param IntegerNumber  $amount   Amount expressed in the smallest units of $currency (e.g. cents).
     * @param Currency $currency Currency of the money object.
     */
    public function __construct(IntegerNumber $amount, Currency $currency)
    {
        $baseCurrency   = new BaseCurrency($currency->getCode()->toNative());
        $this->money    = new BaseMoney($amount->toNative(), $baseCurrency);
        $this->currency = $currency;
    }

    /**
     *  Tells whether two Currency are equal by comparing their amount and currency.
     *
     * @throws TypeException
     */
    public function equals(ValueObject $money): bool
    {
        if (false === Util::classEquals($this, $money)) {
            return false;
        }

        return $this->toNative() === $money->toNative();
    }

    /**
     * Returns money amount.
     *
     * @throws TypeException
     */
    public function getAmount(): IntegerNumber
    {
        return new IntegerNumber((float) $this->money->getAmount());
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
     * @param IntegerNumber $quantity Quantity to add.
     * @throws TypeException
     */
    public function add(IntegerNumber $quantity): Money|ValueObject
    {
        $amount = new IntegerNumber($this->getAmount()->toNative() + $quantity->toNative());
        return new self($amount, $this->getCurrency());
    }

    /**
     * Multiply the Money amount for a given number and returns a new Money object.
     * Use 0 < RealNumber $multiplier < 1 for division.
     *
     * @param ?RoundingMode $roundingMode Rounding mode of the operation. Defaults to RoundingMode::HALF_UP.
     * @throws TypeException
     */
    public function multiply(RealNumber $multiplier, ?RoundingMode $roundingMode = null): Money|ValueObject
    {
        if (null === $roundingMode) {
            $roundingMode = RoundingMode::HALF_UP();
        }

        $amount        = $this->getAmount()->toNative() * $multiplier->toNative();
        $roundedAmount = new IntegerNumber(round($amount, 0, $roundingMode->toNative()));
        return new self($roundedAmount, $this->getCurrency());
    }

    /**
     * Returns a string representation of the Money value in format "CUR AMOUNT" (e.g.: EUR 1000).
     *
     * @throws TypeException
     */
    public function __toString(): string
    {
        return $this->toNative();
    }

    /**
     * Returns a string representation of the Money value in format "CUR AMOUNT" (e.g.: EUR 1000).
     *
     * @throws TypeException
     */
    public function toNative(): string
    {
        return sprintf('%s %d', $this->getCurrency()->getCode(), $this->getAmount()->toNative());
    }
}
