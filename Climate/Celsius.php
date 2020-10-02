<?php

declare(strict_types=1);

namespace Qubus\ValueObjects\Climate;

use Qubus\ValueObjects\Climate\Kelvin;
use Qubus\ValueObjects\Climate\Fahrenheit;
use Qubus\ValueObjects\Climate\Temperature;

class Celsius extends Temperature
{
    /**
     * @return Celsius
     */
    public function toCelsius(): Celsius
    {
        return new static($this->value);
    }

    /**
     * @return Kelvin
     */
    public function toKelvin(): Kelvin
    {
        return new Kelvin($this->value + 273.15);
    }

    /**
     * @return Fahrenheit
     */
    public function toFahrenheit(): Fahrenheit
    {
        return new Fahrenheit($this->value * 1.8 + 32);
    }
}
