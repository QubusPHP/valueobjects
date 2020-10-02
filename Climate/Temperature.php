<?php

declare(strict_types=1);

namespace Qubus\ValueObjects\Climate;

use Qubus\ValueObjects\Number\Real;
use Qubus\ValueObjects\Climate\Kelvin;
use Qubus\ValueObjects\Climate\Celsius;
use Qubus\ValueObjects\Climate\Fahrenheit;

abstract class Temperature extends Real
{
    /**
     * @return Celsius
     */
    abstract public function toCelsius(): Celsius;

    /**
     * @return Kelvin
     */
    abstract public function toKelvin(): Kelvin;

    /**
     * @return Fahrenheit
     */
    abstract public function toFahrenheit(): Fahrenheit;
}
