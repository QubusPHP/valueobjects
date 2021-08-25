<?php

/**
 * Qubus\ValueObjects
 *
 * @link       https://github.com/QubusPHP/valueobjects
 *
 * @since      1.0.0
 */

declare(strict_types=1);

namespace Qubus\ValueObjects\Climate;

use Qubus\ValueObjects\Climate\Celsius;
use Qubus\ValueObjects\Climate\Kelvin;
use Qubus\ValueObjects\Climate\Temperature;

class Fahrenheit extends Temperature
{
    public function toCelsius(): Celsius
    {
        return new Celsius(($this->value - 32) / 1.8);
    }

    public function toKelvin(): Kelvin
    {
        return new Kelvin($this->toCelsius()->toNative() + 273.15);
    }

    public function toFahrenheit(): Fahrenheit
    {
        return new static($this->value);
    }
}
