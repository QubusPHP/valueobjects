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
use Qubus\ValueObjects\Climate\Fahrenheit;
use Qubus\ValueObjects\Climate\Kelvin;
use Qubus\ValueObjects\Number\Real;

abstract class Temperature extends Real
{
    abstract public function toCelsius(): Celsius;

    abstract public function toKelvin(): Kelvin;

    abstract public function toFahrenheit(): Fahrenheit;
}
