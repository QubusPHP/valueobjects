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

namespace Qubus\ValueObjects\Climate;

use Qubus\ValueObjects\Climate\Celsius;
use Qubus\ValueObjects\Climate\Fahrenheit;
use Qubus\ValueObjects\Climate\Temperature;

class Kelvin extends Temperature
{
    public function toCelsius(): Celsius
    {
        return new Celsius($this->value - 273.15);
    }

    public function toKelvin(): Kelvin
    {
        return new static($this->value);
    }

    public function toFahrenheit(): Fahrenheit
    {
        return new Fahrenheit($this->toCelsius()->toNative() * 1.8 + 32);
    }
}
