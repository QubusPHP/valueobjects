<?php

declare(strict_types=1);

namespace Qubus\ValueObjects\Climate;

use Qubus\ValueObjects\Climate\Kelvin;
use Qubus\ValueObjects\Climate\Celsius;
use Qubus\ValueObjects\Climate\Temperature;

class Fahrenheit extends Temperature
{
    /**
     * @return Celsius
     */
    public function toCelsius(): Celsius
    {
        return new Celsius(($this->value - 32) / 1.8);
    }

    /**
     * @return Kelvin
     */
    public function toKelvin(): Kelvin
    {
        return new Kelvin($this->toCelsius()->toNative() + 273.15);
    }

    /**
     * @return Fahrenheit
     */
    public function toFahrenheit(): Fahrenheit
    {
        return new static($this->value);
    }
}
